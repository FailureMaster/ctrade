<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;

trait Searchable
{

    /*
    |--------------------------------------------------------------------------
    | Search Data
    |--------------------------------------------------------------------------
    |
    | This trait basically used in model. This will help to implement search.
    | It could search in multiple column, date to date etc.
    | But this trait unable to make search with multiple table.
    |
    */

    public function initializeAppendAttributeTrait()
    {
        $this->append('appended_property');
    }

    public function scopeSearchable($query, $params, $like = true)
    {
        $search = request()->search;
        if (!$search) {
            return $query;
        }
        if (!is_array($params)) throw new Exception('Parameters should be of the array, but a ' . getType($params) . ' has been provided.');
        $search = $like ? "%$search%" : $search;
        $query->where(function ($q) use ($params, $search) {
            foreach ($params as $key => $param) {
                $relationData = explode(':', $param);
                if (@$relationData[1]) {
                    $q = $this->relationSearch($q, $relationData[0], $relationData[1], $search);
                } else {
                    $column = $param;
                    $q->orWhere($column, 'LIKE', $search);
                }
            }
        });

        return $query;
    }

    public function scopeFilter($query, $params)
    {
        foreach ($params as $param) {
            $relationData = explode(':', $param);
            $filters = array_keys(request()->all());

            if (@$relationData[1]) {
                $query = $this->relationFilter($query, $relationData[0], $relationData[1], $filters);
            } else {
                $column = $param;
                if (in_array($column, $filters) && request()->$column != null) {
                    if (gettype(request()->$column) == 'array') {
                        $query->whereIn($column, request()->$column);
                    } else {
                          $value = $this->getColumnValue($column);
                        if($value == 0){
                            $query->whereNull($column);
                        }else{
                            $query->where($column, $value);
                        }
                    }
                }
            }
        }
        return $query;
    }

    public function scopeDateFilter($query, $column = 'created_at')
    {

        if (!request()->date) {
            return $query;
        }
        try {
            $date      = explode('-', request()->date);
            $startDate = Carbon::parse(trim($date[0]))->format('Y-m-d');
            $endDate = @$date[1] ? Carbon::parse(trim(@$date[1]))->format('Y-m-d') : $startDate;
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['error' => 'Unauthorized action']);
        }

        return  $query->whereDate($column, '>=', $startDate)->whereDate($column, '<=', $endDate);
    }


    private function relationSearch($query, $relation, $columns, $search)
    {
        foreach (explode(',', $columns) as $column) {
            $query->orWhereHas($relation, function ($q) use ($column, $search) {
                $q->where($column, 'like', $search);
            });
        }
        return $query;
    }

    private function relationFilter($query, $relation, $columns, $filters)
    {
        foreach (explode(',', $columns) as $column) {
            if (in_array($column, $filters) && request()->$column != null) {
                $query->whereHas($relation, function ($q) use ($column) {
                    $value = $this->getColumnValue($column);
                    $q->where($column, $value);
                });
            }
        }
        return $query;
    }

    public function scopeCombineColumnValue($query, $value)
    {
        $this->columnValue = $value;
        return $query;
    }

    private function getColumnValue($column)
    {
        if (array_key_exists($column, $this->columnValue ?? []) && array_key_exists(request()->$column, $this->columnValue[$column] ?? [])) {
            return  $this->columnValue[$column][request()->$column];
        }
        return request()->$column;
    }

    public function scopeDateFilterNew($query, $column = 'created_at')
    {

        if (!request()->filter) {
            return $query;
        }
        try {
            $table = $this->getTable();

            // Append the table name to the column
            $column = "{$table}.{$column}";

            $filter = request()->input('filter');
       
            if (request()->input('customfilter')) {
                $filter = 'custom';
            }
        
            $startDate = null;
            $endDate   = null;
    
            switch ($filter) {
                case 'today':
                    $startDate = Carbon::today();
                    $endDate = Carbon::today()->endOfDay();
                    break;
                case 'yesterday':
                    $startDate = Carbon::yesterday();
                    $endDate = Carbon::yesterday()->endOfDay();
                    break;
                case 'this_week':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    break;
                case 'last_week':
                    $startDate = Carbon::now()->subWeek()->startOfWeek();
                    $endDate = Carbon::now()->subWeek()->endOfWeek();
                    break;
                case 'this_month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                case 'last_month':
                    $startDate = Carbon::now()->subMonth()->startOfMonth();
                    $endDate = Carbon::now()->subMonth()->endOfMonth();
                    break;
                case 'custom':
                    $date = explode('-', request()->input('customfilter'));
                    $startDate = Carbon::parse(trim($date[0]))->format('Y-m-d');
                    $endDate = @$date[1] ? Carbon::parse(trim(@$date[1]))->format('Y-m-d') : $startDate;
                    break;
            }

        } catch (\Exception $e) {
            throw ValidationException::withMessages(['error' => 'Unauthorized action']);
        }

        if( $startDate && $endDate)
            return $query->whereDate($column, '>=', $startDate)->whereDate($column, '<=', $endDate);

        return $query;
    }
}

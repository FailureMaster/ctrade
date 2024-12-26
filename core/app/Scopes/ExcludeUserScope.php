<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;


class ExcludeUserScope implements Scope
{
    protected $column;

    public function __construct(string $column = 'id')
    {
        $this->column = $column;
    }

    public function apply(Builder $builder, Model $model)
    {
        $authUser = auth()->guard('admin')->user();

        // Check if the current user is an admin
        if ($authUser && $authUser->id === 1) {
            return; // Do not exclude anything for admins
        }

        // Apply condition to exclude user with ID 1
        if( $authUser <> null ){
           
            // Ownership data
            $includeUserIds = User::withoutGlobalScopes()->where('owner_id', $authUser->id)->pluck('id')->toArray();

            $excludedUserIds = User::withoutGlobalScopes()->where('account_type', 'test')->pluck('id')->toArray();
            
            if( $authUser->permission_group_id == 1 ){
                $builder->whereNotIn($this->column, [1]);
            }
            else{
                $builder->whereNotIn($this->column, array_merge($excludedUserIds, [1]))->whereIn($this->column, $includeUserIds);
            }
            
            // $builder->whereNotIn($this->column, array_merge($excludedUserIds, [1000]))->whereIn($this->column, $includeUserIds);
            // $builder->where($this->column, '!=', 1);
        }
    }
}

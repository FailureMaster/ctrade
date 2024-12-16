<?php

namespace App\Scopes;

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
            $builder->where($this->column, '!=', 1);
        }
    }
}

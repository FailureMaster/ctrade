<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission = null)
    // Checks every permission in provided string split by | and returns $next($request) only if
    // ALL permissions are granted for admin who makes request
    {
        // return $next($request);

        $permission_arr = explode('|', $permission);
        if (auth()->guard('admin')->user()->id == 1) {
            return $next($request);
        }
        $permission_group = auth()->guard('admin')->user()->group->permissions();

        // foreach ($permission_arr as $item) {
        //     if ($get_single_per = $permission_group->where('name', $item)->first()) {
               
        //         if ($get_single_per['value']) {
        //             return $next($request);
        //         }
        //     }
        // }

        $activePermissions = [];
    
        foreach( $permission_group as $item ){
            foreach( $item as $i ){
                if( $i['value'] ){ 
                    array_push($activePermissions, $i['name']);
                }
            }
        }
    
        foreach ($permission_arr as $item) {
            if( in_array($item, $activePermissions) ){
                return $next($request);
            }
        }

        return to_route('admin.dashboard')->with('alert', 'Unauthorised access');
    }
}

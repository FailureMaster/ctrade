<?php

namespace App\Http\Middleware;

use Closure;
use Pusher\Pusher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $admin->last_activity = Carbon::now();
            $admin->save();
             // Determine if the admin is active
             $isActive = \Carbon\Carbon::parse($admin->last_activity) > Carbon::now()->subMinutes(1);

             // Set up Pusher
             $pusher = new Pusher(
                'c5afd2b879ff37c4a429',
                 'bc91ce796e70e0861721',
                 '1688847',
                 [
                     'cluster' => 'ap2',
                     'useTLS' => true,
                 ]
             );
 
             // Data to send to Pusher
             $data = [
                 'adminId' => $admin->id,
                 'isActive' => $isActive,
                 'message' => $isActive ? 'Admin is online' : 'Admin is offline',
             ];
 
             // Trigger the event on Pusher
             $pusher->trigger('admin-status-channel', 'admin-online-status', $data);
        }
        return $next($request);
    }
}

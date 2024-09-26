<?php

namespace App\Http\Middleware;

use App\Models\BlacklistCountry;
use Closure;
use Illuminate\Http\Request;

class CountryBlacklistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = getRealIP();
        $country = getCountryFromGeoPlugin($ip);

        // if (!$country) {
        //     return response()->json(['error' => 'Unable to retrieve country information.'], 500);
        // }

        $blacklistedCountries = BlacklistCountry::pluck('name')->map(function ($name) {
            return strtolower($name); // Lowercase blacklisted country names
        })->toArray();

        if (in_array(strtolower($country), $blacklistedCountries)) {
            // You can log or handle the blacklisting here
            return response()->json('Access from your country is restricted.', 403);
        }

        return $next($request);
    }
}
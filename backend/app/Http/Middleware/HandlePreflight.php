<?php

namespace App\Http\Middleware;

use Closure;

class HandlePreflight
{
    public function handle($request, Closure $next)
    {
                if ($request->getMethod() === "OPTIONS") {
                    return response('')
                        ->header('Access-Control-Allow-Origin', '*')
                        ->header('Access-Control-Allow-Credentials', 'true')
                        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                        ->header('Access-Control-Allow-Headers', 'Accept, content-type, X-Auth-Token, Origin, Authorization');
                }

//         if ($request->getMethod() === 'OPTIONS') {
//             return response()->json('OK', 200, [
//                 'Access-Control-Allow-Origin' => 'https://osecours-front-eu-851bfe93cb8c.herokuapp.com',
//                 'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
//                 'Access-Control-Allow-Headers' => 'Content-Type, Accept, X-Auth-Token, Origin, Authorization',
//             ]);
//         }

        return $next($request);
    }
}

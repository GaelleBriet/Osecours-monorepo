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
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Accept, Content-Type, X-Auth-Token, Origin, Authorization');
        }

        return $next($request);
    }
}

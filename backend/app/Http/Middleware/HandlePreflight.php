<?php

namespace App\Http\Middleware;

use Closure;

class HandlePreflight
{
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() === "OPTIONS") {
            return response('', 204)
                ->header('Access-Control-Allow-Origin', config('cors.allowed_origins')[0])
                ->header('Access-Control-Allow-Methods', implode(',', config('cors.allowed_methods')))
                ->header('Access-Control-Allow-Headers', implode(',', config('cors.allowed_headers')))
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', config('cors.max_age'));
        }
//                         ->header('Access-Control-Allow-Headers', 'Accept, content-type, X-Auth-Token, Origin, Authorization');      ]);

        return $next($request);


    }
}

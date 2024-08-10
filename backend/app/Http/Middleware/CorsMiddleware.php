<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }

        $response->headers->set('Access-Control-Allow-Origin', config('cors.allowed_origins')[0]);
        $response->headers->set('Access-Control-Allow-Methods', implode(',', config('cors.allowed_methods')));
        $response->headers->set('Access-Control-Allow-Headers', implode(',', config('cors.allowed_headers')));
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', config('cors.max_age'));
//         $response->headers->set('Access-Control-Allow-Headers', 'content-type, Accept, X-Auth-Token, Origin, Authorization, Cookie');


        return $response;
    }
}

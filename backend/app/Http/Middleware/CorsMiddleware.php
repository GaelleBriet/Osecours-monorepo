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
        $response->headers->set('Access-Control-Allow-Origin', 'https://www.osecours-asso.fr');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'content-type, Accept, X-Auth-Token, Origin, Authorization, Cookie');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', config('cors.max_age'));
//         $response->headers->set('Access-Control-Allow-Headers', 'content-type, Accept, X-Auth-Token, Origin, Authorization, Cookie');
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        }

        return $response;
    }
}

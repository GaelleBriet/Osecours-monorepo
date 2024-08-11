<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $response = $next($request);

        // Récupérer l'origine de la requête
        $origin = $request->headers->get('origin');

        // Vérifier si l'origine est dans la liste des origines autorisées
        if (in_array($origin, config('cors.allowed_origins'))) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        $response->headers->set('Access-Control-Allow-Methods', implode(',', config('cors.allowed_methods')));
        $response->headers->set('Access-Control-Allow-Headers', implode(',', config('cors.allowed_headers')));
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', config('cors.max_age'));

        return $response;
    }
}

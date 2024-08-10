<?php

use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\HandlePreflight;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            'preflight' => HandlePreflight::class,
            'cors' => CorsMiddleware::class,
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
        ]);
        $middleware->append([
            CorsMiddleware::class,
            HandlePreflight::class,
        ]);
//          $middleware->use([CorsMiddleware::class]);
//         ->withCors(function (Cors $cors) {
//             $cors->paths(['api/*', 'sanctum/csrf-cookie']);
//             $cors->allowedMethods(['*']);
//             $cors->allowedOrigins(['*']);
//             $cors->allowedHeaders(['*']);
//             $cors->supportsCredentials(true);
//         });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

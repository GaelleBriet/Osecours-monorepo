<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="O'Secours",
 *         version="1.0",
 *         description="API pour gérer des ressources"
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000/api",
 *         description="API Server"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT",
 *             description="JWT Authorization header using the Bearer scheme."
 *         )
 *     )
 * )
 */
abstract class Controller
{
    //
}

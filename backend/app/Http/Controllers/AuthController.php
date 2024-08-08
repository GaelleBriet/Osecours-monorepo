<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\AuthRequest;
use App\Http\Services\AuthService;
use App\Http\Services\ErrorService;
use Exception;

class AuthController extends Controller
{
    protected ErrorService $errorService;

    public function __construct(ErrorService $eService)
    {
        $this->errorService = $eService;
    }

     /**
     * @OA\Post(
     *     path="/token/create",
     *     summary="Get token",
     *     tags={"Authentication"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="create token for specific association",
     *
     *         @OA\JsonContent(
     *             required={"email","password"},
     *
     *             @OA\Property(property="email", type="string", example="admin-lerefugedeschimeres@osecours.org", format="email" ),
     *             @OA\Property(property="password", type="string", example="P@ssword_1" ),
     *             @OA\Property(property="association_id", type="integer", example=1 ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Token created successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getToken(AuthRequest $request): \Illuminate\Http\JsonResponse
    {

        try {

            $request->validated();
            $credentials = $request->only('email', 'password');
            $currentAssociationId = $request->get('association_id');

            if (! $currentAssociationId) {
                return response()->json(['data' => AuthService::getTokenWithoutAssociation($credentials)], 201);
            }

            return response()->json(['data' => AuthService::getTokenForSpecificAssociation($credentials, $currentAssociationId)], 201);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

/**
 * @OA\Post(
 *     path="/login",
 *     summary="User login",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="User login credentials",
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
    public function login(AuthRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validated();
            $credentials = $request->only('email', 'password');

//            return response()->json(['data' => AuthService::connectUser($credentials)], 200);
            $authService = new AuthService();
            return response()->json(['data' => $authService->connectUser($credentials)], 200);
        } catch (UnauthorizedException $e) {
            return $this->errorService->handle($e);
//            return response()->json([
//                'error' => 'Unauthorized',
//                'message' => $e->getMessage(),
//                'status' => $e->getCode()
//            ], $e->getCode());
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}

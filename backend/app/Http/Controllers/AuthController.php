<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Http\Requests\AuthRequest;
use App\Http\Services\AuthService;
use App\Http\Services\ErrorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $errorService;

    public function __construct(ErrorService $eService)
    {
        $this->errorService = $eService;
    }

     /**
     * @OA\Post(
     *     path="/token/create",
     *     summary="Get token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="create token for specific association",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="admin-lerefugedeschimeres@osecours.org", format="email" ),
     *             @OA\Property(property="password", type="string", example="P@ssword_1" ),
     *             @OA\Property(property="association_id", type="integer", example=1 ),
     *         )
     *     ),
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
    public function getToken(AuthRequest $request)
    {

        try {

            $request->validated();
            $credentials = $request->only('email', 'password');
            $currentAssociationId = $request->get('association_id');

            if (!$currentAssociationId) {
                return response()->json(["data" => AuthService::getTokenWithoutAssociation($credentials)], 201);
            }
            return response()->json(["data" => AuthService::getTokenForSpecificAssociation($credentials, $currentAssociationId)], 201);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function login(AuthRequest $request)
    {
        try {
            $request->validated();
            $credentials = $request->only('email', 'password');
            return response()->json(["data" => AuthService::connectUser($credentials)], 200);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Http\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $currentAssociationId = $request->get('association_id');

            if (!$currentAssociationId) {
                return response()->json(["data" => AuthService::getTokenWithoutAssociation($credentials)], 201);
            }
            return response()->json(["data" => AuthService::getTokenForSpecificAssociation($credentials, $currentAssociationId)], 201);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage(), 500]);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            return response()->json(["data" => AuthService::connectUser($credentials)], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage(), 500]);
        }
    }
}

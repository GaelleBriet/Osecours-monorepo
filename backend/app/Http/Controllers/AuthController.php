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
        $credentials = $request->only('email', 'password');
        $currentAssociationId = $request->get('association_id');
        
        if(!$currentAssociationId){
            return AuthService::getTokenWithoutAssociation($credentials);
        }
        return AuthService::getTokenForSpecificAssociation($credentials,$currentAssociationId);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        return AuthService::connectUser($credentials);
    }
}

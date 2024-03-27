<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Http\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $currentAssociation = $request->get('association');
        
        if(!$currentAssociation){
            return AuthService::getTokenWithoutAssociation($credentials);
        }
        return AuthService::getTokenForSpecificAssociation($credentials,$currentAssociation);
    }
}

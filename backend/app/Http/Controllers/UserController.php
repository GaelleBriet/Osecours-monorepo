<?php

namespace App\Http\Controllers;

use App\Contract\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->users = $userRepository;
    }

    public function getAll(){

        return $this->users->all();
    }

    public function getUserByAssociationAndUser(Request $request){
        $associationId = $request->get("association_id");
       return $this->users->findByAssociationAndUser($associationId,Auth::user());   
    }
}

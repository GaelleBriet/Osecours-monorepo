<?php

namespace App\Http\Controllers;

use App\Contract\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->users = $userRepository;
    }

    public function getAll()
    {

        try {
            return response()->json(["data" => $this->users->all()],200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage(), 500]);
        }
    }

    public function getUserByAssociationAndUser(Request $request)
    {

        try {
            $associationId = $request->get("association_id");
            return response()->json(["data" => $this->users->findByAssociationAndUser($associationId, Auth::user())],200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage(), 500]);
        }
    }
}

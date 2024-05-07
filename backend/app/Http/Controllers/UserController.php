<?php

namespace App\Http\Controllers;

use App\Contract\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenApi\Annotations as OA;

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

    /**
     * @OA\Get(
     *     path="/users/role",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
      *     @OA\Parameter(
      *         name="role",
      *         in="query",
      *         description="The role of the user",
      *         required=true,
      *         @OA\Schema(
      *             type="string"
      *         )
      *     ),
      *     @OA\Parameter(
      *         name="currentAssociationId",
      *         in="query",
      *         description="The ID of the current association",
      *         required=true,
      *         @OA\Schema(
      *             type="integer"
      *         )
      *     ),
     *     @OA\Response(response="200", description="get users by role & association")
     *
     * )
     */
    public function getUserByRole(Request $request)
    {
        try {
            $role = $request->get("role");
            $currentAssociationId = $request->get('currentAssociationId');

            if (!$role || !$currentAssociationId) {
                return response()->json(["error" => "Role and currentAssociationId parameters are required"], 400);
            }

            $users = User::whereHas('roles', function ($query) use ($role) {
                $query->where('roles.name', $role);
            })->whereHas('associations', function ($query) use ($currentAssociationId) {
                $query->where('associations.id', $currentAssociationId);
            })->get();

            return response()->json(["data" => $users], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}

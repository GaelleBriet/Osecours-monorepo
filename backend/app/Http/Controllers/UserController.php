<?php

namespace App\Http\Controllers;

use App\Contract\UserRepositoryInterface;
use App\Models\User;
use App\Http\Services\ErrorService;
use App\Http\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    protected $users;
    protected UserService $userService;
    protected ErrorService $errorService;

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService, ErrorService $errorService)
    {
        $this->users = $userRepository;
        $this->userService = $userService;
        $this->errorService = $errorService;
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

    public function delete($id)
    {
        try {
            $deletedUser = $this->userService->softDelete($id);
            return response()->json([
                'message' => 'User deleted successfully',
                'data' => $deletedUser
            ]);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Contract\UserRepositoryInterface;
use App\Http\Services\ErrorService;
use App\Http\Services\RoleService;
use App\Http\Services\UserService;
use App\Models\Association;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    protected $users;

    protected UserService $userService;

    protected ErrorService $errorService;

    protected RoleService $roleService;

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService, ErrorService $errorService, RoleService $roleService)
    {
        $this->users = $userRepository;
        $this->userService = $userService;
        $this->errorService = $errorService;
        $this->roleService = $roleService;
    }

    public function getAll()
    {

        try {
            return response()->json(['data' => $this->users->all()], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }

    public function getUserByAssociationAndUser(Request $request)
    {

        try {
            $associationId = $request->get('association_id');

            return response()->json(['data' => $this->users->findByAssociationAndUser($associationId, Auth::user())], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/role",
     *     summary="Get list of users by role & association",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="The role of the user",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="currentAssociationId",
     *         in="query",
     *         description="The ID of the current association",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(response="200", description="get users by role & association")
     *
     * )
     */
    public function getAllUsersByRoleAndAssociation(Request $request)
    {
        try {
            $role = $request->get('role');
            $currentAssociationId = $request->get('currentAssociationId');

            if (! $role || ! $currentAssociationId) {
                return response()->json(['error' => 'Role and currentAssociationId parameters are required'], 400);
            }

            $users = $this->users->findByRoleAndAssociation($role, $currentAssociationId);

            return response()->json(['data' => $users], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *    security={{"bearerAuth":{}}},
     *     summary="Get specific user details",
     *     description="Return informations for an user with specific id",
     *     operationId="getUserById",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user Id to fetch",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User fetched successfully",
     *
     *         @OA\JsonContent(
     *             ref="#/components/schemas/User"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server Error"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return $this->userService->getById($id);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *   security={{"bearerAuth":{}}},
     *     summary="Delete specific user (soft delete)",
     *     description="Make a soft delete for an user with specific id",
     *     operationId="deleteUserById",
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de l'utilisateur à supprimer",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User supprimé avec succès",
     *
     *         @OA\JsonContent(
     *             ref="#/components/schemas/User"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="User non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne"
     *     )
     * )
     */
    public function delete($id)
    {
        try {
            $deletedUser = $this->userService->softDelete($id);

            return response()->json([
                'message' => 'User deleted successfully',
                'data' => $deletedUser,
            ]);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *
     *     @OA\RequestBody(
     *         description="User data",
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="first_name",
     *                 type="string",
     *                 description="The first name of the user",
     *                 example="John"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 description="The last name of the user",
     *                 example="Doe"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 description="The phone number of the user",
     *                 example="1234567890"
     *             ),
     *             @OA\Property(
     *                 property="existing_cat_count",
     *                 type="integer",
     *                 description="The number of existing cats the user has",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="existing_children_count",
     *                 type="integer",
     *                 description="The number of existing children the user has",
     *                 example=3
     *             ),
     *             @OA\Property(
     *                 property="existing_dog_count",
     *                 type="integer",
     *                 description="The number of existing dogs the user has",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="The email of the user",
     *                 example="john.doe@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="The password of the user",
     *                 example="Password123!"
     *             ),
     *             @OA\Property(
     *                 property="role_id",
     *                 type="integer",
     *                 description="The ID of the role of the user",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="association_id",
     *                 type="integer",
     *                 description="The ID of the association of the user",
     *                 example=1
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User created successfully",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message",
     *                 example="User and role created successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     ),
     * )
     */
    public function create(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'existing_cat_count' => 'required',
                'existing_children_count' => 'required',
                'existing_dog_count' => 'required',
                'email' => 'required|email|unique:users',
                'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/'],
                'role_id' => 'required|exists:roles,id', // on s'assure que le rôle existe
                'association_id' => 'required|exists:associations,id', // on s'assure que l'association existe
            ]);

            $user = $this->userService->create($validatedData);

            if ($user) {
                // Récupérer les instances de Role et Association
                $roleToAttach = Role::findOrFail($validatedData['role_id']);
                $boundedAssociation = Association::findOrFail($validatedData['association_id']);

                // Attacher le rôle à l'utilisateur
                $this->roleService->attachRoleOnUser($roleToAttach, $user, $boundedAssociation);
            }

            return response()->json([
                'message' => 'User ans role created successfully',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/{id}/role",
     *     summary="Get the role of a user for a specific association",
     *     security={{"bearerAuth":{}}},
     *     tags={"Users"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="association_id",
     *         in="query",
     *         description="ID of the association",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Role of the user for the specific association",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Role"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function getUserRole(Request $request)
    {
        try {
            $userId = $request->route('id');
            $associationId = $request->get('association_id');

            $role = $this->users->getUserRole($userId, $associationId);

            return response()->json(['role_id' => $role], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Contract\RoleRepositoryInterface;
use App\Http\Services\RoleService;
use App\Models\Association;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function getAll()
    {

        $this->roleService->getAll();
    }

    public function addRoleOnUser(Request $request)
    {

        try {

            $roleToAttach = Role::findOrFail($request->get("role_id"));
            $targetedUser = User::findOrFail($request->get("user_id"));
            $boundedAssociation = Association::findOrFail($request->get("association_id"));

            if ($this->roleService->checkIfUserExistInAssociation($targetedUser, $boundedAssociation)) {
                if (!$this->roleService->checkIfRoleAlreadyExistInAssociation($targetedUser, $boundedAssociation, $roleToAttach)) {
                    $this->roleService->attachRoleOnUser($roleToAttach, $targetedUser, $boundedAssociation);
                    return response()->json(['data' => 'role has been added successfully'], 200);
                } else {
                    $message = "role " . $roleToAttach->name . " already exist on this user";
                    return response()->json(['data' => $message], 201);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

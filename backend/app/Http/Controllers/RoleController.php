<?php

namespace App\Http\Controllers;

use App\Exceptions\RoleAlreadyExistException;
use App\Http\Services\ErrorService;
use App\Http\Services\RoleService;
use App\Models\Association;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected RoleService $roleService;
    protected ErrorService $errorService;

    public function __construct(RoleService $roleService, ErrorService $eService)
    {
        $this->roleService = $roleService;
        $this->errorService = $eService;
    }

    public function getAll()
    {
        try {
            $this->roleService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
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
                    throw new RoleAlreadyExistException($message);
                }
            }
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}

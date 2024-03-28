<?php 

namespace App\Http\Services;

use App\Contract\RoleRepositoryInterface;
use App\Models\Association;
use App\Models\Role;
use App\Models\User;
use App\Repositories\RoleRepository;

class RoleService {

    protected RoleRepositoryInterface $roles;

    public function __construct(RoleRepository $roleRepository){
        $this->roles = $roleRepository;
    }

    public function getAll(){
       return $this->roles->all();
    }

    public function checkIfUserExistInAssociation(User $user, Association $association): bool {

        return $user->associations()
        ->wherePivot('association_id', $association->id) 
        ->exists(); 
    } 

    public function checkIfRoleAlreadyExistInAssociation(User $user, Association $association, Role $role): bool{

        return $user->roles()
        ->wherePivot('association_id', $association->id)
        ->wherePivot('role_id', $role->id)
        ->exists();
    }

    public function attachRoleOnUser(Role $roleToAttach, User $targetedUser,Association $boundedAssociation){
        return $this->roles->attachRoleOnUser($roleToAttach,$targetedUser,$boundedAssociation);
    }
}
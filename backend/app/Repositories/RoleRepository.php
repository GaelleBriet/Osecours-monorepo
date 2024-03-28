<?php

namespace App\Repositories;

use App\Contract\RoleRepositoryInterface;
use App\Models\Association;
use App\Models\Role;
use App\Models\User;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

   public function attachRoleOnUser(Role $role, User $user, Association $association)
   {
      return $user->roles()->attach($role->id,["association_id" => $association->id]);
   }
}

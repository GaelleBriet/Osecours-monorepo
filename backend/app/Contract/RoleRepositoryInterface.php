<?php

namespace App\Contract;

use App\Models\Association;
use App\Models\User;
use App\Models\Role;

interface RoleRepositoryInterface
{
    public function all();

    public function find($id);

    public function attachRoleOnUser(Role $role, User $user, Association $association);

}

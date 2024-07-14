<?php

namespace App\Contract;

use App\Models\Association;
use App\Models\Role;
use App\Models\User;

interface RoleRepositoryInterface
{
    public function all(): mixed;

    /**
     * @return mixed
     */
    public function find($id);

    public function attachRoleOnUser(Role $role, User $user, Association $association): mixed;
}

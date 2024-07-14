<?php

namespace App\Contract;

use App\Models\Association;
use App\Models\Role;
use App\Models\User;

interface RoleRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param Role $role
     * @param User $user
     * @param Association $association
     * @return mixed
     */
    public function attachRoleOnUser(Role $role, User $user, Association $association): mixed;
}

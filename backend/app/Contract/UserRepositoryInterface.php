<?php

namespace App\Contract;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();

    public function find($id);

    public function findByEmailAndAssociation($email, $associationId);

    public function findByAssociationAndUser($associationId,User $user);

    public function findByRoleAndAssociation($role, $currentAssociationId);

    public function findByRole(string $role);

    public function getAllAssociationsFromUser(User $user);

    public function softDelete($id);

    public function create(User $user);

    public function getUserRole($userId, $associationId);
}

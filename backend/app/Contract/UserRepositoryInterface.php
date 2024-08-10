<?php

namespace App\Contract;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all(): mixed;

    public function find($id): mixed;

    public function findByEmailAndAssociation($email, $associationId): mixed;

    public function findByAssociationAndUser($associationId, User $user): mixed;

    public function findByRoleAndAssociation($role, $currentAssociationId): mixed;

    public function findByRole(string $role): mixed;

    public function getAllAssociationsFromUser(User $user): mixed;

    public function softDelete($id): mixed;

    public function create(User $user): mixed;

    public function getUserRole($userId, $associationId): mixed;
}

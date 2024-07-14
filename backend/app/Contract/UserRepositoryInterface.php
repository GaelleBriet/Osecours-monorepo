<?php

namespace App\Contract;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed;

    /**
     * @param $email
     * @param $associationId
     * @return mixed
     */
    public function findByEmailAndAssociation($email, $associationId): mixed;

    /**
     * @param $associationId
     * @param User $user
     * @return mixed
     */
    public function findByAssociationAndUser($associationId, User $user): mixed;

    /**
     * @param $role
     * @param $currentAssociationId
     * @return mixed
     */
    public function findByRoleAndAssociation($role, $currentAssociationId): mixed;

    /**
     * @param string $role
     * @return mixed
     */
    public function findByRole(string $role): mixed;

    /**
     * @param User $user
     * @return mixed
     */
    public function getAllAssociationsFromUser(User $user): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function softDelete($id): mixed;

    /**
     * @param User $user
     * @return mixed
     */
    public function create(User $user): mixed;

    /**
     * @param $userId
     * @param $associationId
     * @return mixed
     */
    public function getUserRole($userId, $associationId): mixed;
}

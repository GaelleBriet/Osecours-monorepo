<?php

namespace App\Repositories;

use App\Contract\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByEmailAndAssociation($email, $associationId): mixed
    {
        return User::where('email', $email)
            ->whereHas('associations', function ($query) use ($associationId) {
                $query->where('associations.id', $associationId);
            })->first();
    }

    public function findByAssociationAndUser($associationId, User $user): mixed
    {
        return $user->whereHas('associations', function ($query) use ($associationId) {
            $query->where('associations.id', $associationId);
        })->where('users.id', $user->id)
            ->first();
    }

    public function findByRoleAndAssociation($role, $currentAssociationId): mixed
    {
        return $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('roles.name', $role);
        })->whereHas('associations', function ($query) use ($currentAssociationId) {
            $query->where('associations.id', $currentAssociationId);
        })->get();
    }

    public function findByRole(string $role): mixed
    {
        return User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
    }

    public function find($id): mixed
    {
        return User::with('associations')->findOrFail($id);
    }

    public function getAllAssociationsFromUser(User $user): mixed
    {
        return $user->associations;
    }

    public function softDelete($id): mixed
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }

    public function create(array|User $user): User
    {
        return User::create($user);
    }

    public function getUserRole($userId, $associationId): mixed
    {

        $user = User::find($userId);

        if ($user) {
            $role = $user->roles()
                ->wherePivot('association_id', $associationId)
                ->withPivot('role_id')
                ->first();

            if ($role) {
                return $role->pivot->role_id;
            }
        }

        return null;
    }
}

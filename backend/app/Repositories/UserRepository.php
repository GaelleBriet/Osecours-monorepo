<?php

namespace App\Repositories;

use App\Contract\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByEmailAndAssociation($email, $associationId)
    {
        return User::where('email', $email)
        ->whereHas('associations', function ($query) use ($associationId) {
            $query->where('associations.id', $associationId);
        })->first();
    }

    public function findByAssociationAndUser($associationId, User $user)
    {
        return $user->whereHas('associations', function ($query) use ($associationId) {
            $query->where('associations.id', $associationId);
        })->where('users.id', $user->id)
        ->first();
    }

    public function findByRoleAndAssociation($role, $currentAssociationId)
    {
        return $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('roles.name', $role);
        })->whereHas('associations', function ($query) use ($currentAssociationId) {
            $query->where('associations.id', $currentAssociationId);
        })->get();
    }

    public function findByRole(string $role)
    {
       return User::whereHas('roles', function ($query) use ($role) {
           $query->where('name', $role);
       })->get();
    }

    public function find($id)
    {
        return User::with('associations')->findOrFail($id);
    }

    public function getAllAssociationsFromUser(User $user){
        return $user->associations;
    }

    public function softDelete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }

    public function create($user){
        return User::create($user);
    }

    public function getUserRole($userId, $associationId){

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
    }
}

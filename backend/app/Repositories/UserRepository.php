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

    public function findByRole(string $role)
    {
       return User::whereHas('roles', function ($query) use ($role) {
           $query->where('name', $role);
       })->get();
    }

    public function getAllAssociationsFromUser(User $user){
        return $user->associations;
    }

    public function softDelete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }

}

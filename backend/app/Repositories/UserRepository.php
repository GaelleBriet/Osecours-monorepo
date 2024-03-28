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

    public function getAllAssociationsFromUser(User $user){
        return $user->associations;
    }

}

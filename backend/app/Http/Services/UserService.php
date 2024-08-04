<?php

namespace App\Http\Services;

use App\Contract\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getById($id)
    {
        return $this->userRepository->find($id);
    }

    public function softDelete($id)
    {
        return $this->userRepository->softDelete($id);
    }

    public function create($validatedData)
    {
        // Création de l'utilisateur
        $user = [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'phone' => $validatedData['phone'],
            'existing_cat_count' => $validatedData['existing_cat_count'],
            'existing_children_count' => $validatedData['existing_children_count'],
            'existing_dog_count' => $validatedData['existing_dog_count'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // hacher le mot de passe
        ];

        return $this->userRepository->create($user);
    }
}

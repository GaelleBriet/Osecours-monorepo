<?php

namespace App\Http\Services;

use App\Contract\UserRepositoryInterface;

class UserService {

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function softDelete($id){
        return $this->userRepository->softDelete($id);
    }
}

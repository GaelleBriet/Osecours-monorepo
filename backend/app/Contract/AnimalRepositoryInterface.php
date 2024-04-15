<?php

namespace App\Contract;

use App\Models\User;

interface AnimalRepositioryInterface
{
    public function all();

    public function find($id);

    public function create($animal);
}

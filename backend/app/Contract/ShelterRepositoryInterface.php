<?php

namespace App\Contract;

interface ShelterRepositoryInterface
{
    public function all(): mixed;

    public function find($id): mixed;

    public function create($shelter): mixed;

    public function update($id, $updatedDatas): mixed;

    public function softDelete($id): mixed;
}

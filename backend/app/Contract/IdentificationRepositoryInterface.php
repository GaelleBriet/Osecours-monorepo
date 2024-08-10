<?php

namespace App\Contract;

interface IdentificationRepositoryInterface
{
    public function all(): mixed;

    public function find($id): mixed;

    public function create(array $data): mixed;

    public function update($id, array $updatedDatas): mixed;
}

<?php

namespace App\Contract;

interface AnimalRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all();

    public function find($id): mixed;

    public function create($animal): mixed;

    public function update($id, $updatedDatas): mixed;

    public function softDelete($id): mixed;
}

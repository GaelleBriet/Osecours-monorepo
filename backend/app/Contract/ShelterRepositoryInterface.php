<?php

namespace App\Contract;

interface ShelterRepositoryInterface
{
    public function all();

    public function find($id);

    public function create($animal);

    public function update($id, $updatedDatas);

    public function softDelete($id);
}

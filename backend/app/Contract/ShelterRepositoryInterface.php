<?php

namespace App\Contract;

interface ShelterRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed;

    /**
     * @param $animal
     * @return mixed
     */
    public function create($animal): mixed;

    /**
     * @param $id
     * @param $updatedDatas
     * @return mixed
     */
    public function update($id, $updatedDatas): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function softDelete($id): mixed;
}

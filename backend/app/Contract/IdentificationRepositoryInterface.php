<?php

namespace App\Contract;

interface IdentificationRepositoryInterface
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
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * @param $id
     * @param array $updatedDatas
     * @return mixed
     */
    public function update($id, array $updatedDatas): mixed;
}

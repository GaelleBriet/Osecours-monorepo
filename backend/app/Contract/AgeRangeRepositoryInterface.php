<?php

namespace App\Contract;

use App\Models\AgeRange;

interface AgeRangeRepositoryInterface
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
     * @param array $ageRange
     * @return mixed
     */
    public function create(array $ageRange): mixed;

    /**
     * @param AgeRange $ageRange
     * @return mixed
     */
    public function update(AgeRange $ageRange): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed;
}

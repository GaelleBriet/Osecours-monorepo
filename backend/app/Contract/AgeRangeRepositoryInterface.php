<?php

namespace App\Contract;

use App\Models\AgeRange;

interface AgeRangeRepositoryInterface
{
    public function all(): mixed;

    public function find($id): mixed;

    public function create(array $ageRange): mixed;

    public function update(AgeRange $ageRange): mixed;

    public function delete($id): mixed;
}

<?php

namespace App\Contract;

use App\Models\AgeRange;

interface AgeRangeRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $ageRange);

    public function update(AgeRange $ageRange);

    public function delete($id);
}

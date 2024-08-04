<?php

namespace App\Repositories;

use App\Contract\IdentificationRepositoryInterface;
use App\Models\Identification;

class IdentificationRepository extends BaseRepository implements IdentificationRepositoryInterface
{
    public function __construct(Identification $identification)
    {
        parent::__construct($identification);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Identification::all();
    }

    public function find($id): mixed
    {
        return Identification::findOrFail($id);
    }

    public function create(array $data): mixed
    {
        return Identification::create($data);
    }

    public function update($id, $updatedDatas): mixed
    {
        $currentIdentitification = Identification::findOrFail($id);
        $currentIdentitification->update($updatedDatas);

        return $currentIdentitification->save();
    }
}

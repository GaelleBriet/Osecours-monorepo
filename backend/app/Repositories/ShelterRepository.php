<?php

namespace App\Repositories;

use App\Contract\ShelterRepositoryInterface;
use App\Models\Shelter;

class ShelterRepository extends BaseRepository implements ShelterRepositoryInterface
{
    public function __construct(Shelter $shelter)
    {
        parent::__construct($shelter);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {

        return Shelter::all();
    }

    public function create($shelter): mixed
    {
        return Shelter::create($shelter);
    }

    public function update($id, $updatedDatas): mixed
    {
        $shelter = Shelter::find($id);
        if ($shelter) {
            $shelter->update($updatedDatas);
        }

        return $shelter;
    }

    public function find($id): mixed
    {
        return Shelter::withTrashed()
            ->findOrFail($id);
    }

    public function softDelete($id): mixed
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->delete();

        return $shelter;
    }
}

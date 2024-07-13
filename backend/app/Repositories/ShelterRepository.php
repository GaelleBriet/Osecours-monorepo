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

    public function all()
    {

        return Shelter::all();
    }

    public function create($shelter)
    {
        return Shelter::create($shelter);
    }

    public function update($id, $updatedDatas)
    {
        $shelter = Shelter::find($id);
        if ($shelter) {
            $shelter->update($updatedDatas);
        }

        return $shelter;
    }

    public function find($id)
    {
        return Shelter::withTrashed()
            ->findOrFail($id);
    }

    public function softDelete($id)
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->delete();

        return $shelter;
    }
}

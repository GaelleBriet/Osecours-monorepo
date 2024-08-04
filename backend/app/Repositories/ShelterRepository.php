<?php

namespace App\Repositories;

use App\Contract\ShelterRepositoryInterface;
use App\Http\Resources\ShelterResource;
use App\Models\Shelter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShelterRepository extends BaseRepository implements ShelterRepositoryInterface
{
    public function __construct(Shelter $shelter)
    {
        parent::__construct($shelter);
    }

    public function all(): AnonymousResourceCollection
    {
        $shelters = Shelter::all();
        return ShelterResource::collection($shelters);
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
        $shelter = Shelter::withTrashed()->findOrFail($id);
        return new ShelterResource($shelter);
    }

    public function softDelete($id): mixed
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->delete();

        return $shelter;
    }
}

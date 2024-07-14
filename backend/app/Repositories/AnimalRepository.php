<?php

namespace App\Repositories;

use App\Contract\AnimalRepositoryInterface;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;

class AnimalRepository extends BaseRepository implements AnimalRepositoryInterface
{
    public function __construct(Animal $animal)
    {
        parent::__construct($animal);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        $animals = Animal::with(['identification'])->get();

        return AnimalResource::collection($animals);
    }

    public function create($animal): mixed
    {
        return Animal::create($animal);
    }

    public function update($id, $updatedDatas): mixed
    {
        $animal = Animal::find($id);
        if ($animal) {
            $animal->update($updatedDatas);
        }

        return $animal;
    }

    public function find($id): AnimalResource
    {
        $animal = Animal::with(['specie', 'gender', 'color', 'coat', 'SizeRange', 'AgeRange', 'identification'])
            ->withTrashed()
            ->findOrFail($id);

        return new AnimalResource($animal);
    }

    public function softDelete($id): mixed
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();

        return $animal;
    }
}

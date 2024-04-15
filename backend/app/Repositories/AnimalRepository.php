<?php

namespace App\Repositories;

use App\Contract\AnimalRepositoryInterface;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;

class AnimalRepository extends BaseRepository implements AnimalRepositoryInterface{

    public function __construct(Animal $animal)
    {
        parent::__construct($animal);
    }

    public function all(){
        $animals = Animal::with(['specie', 'gender', 'color', 'coat', 'size_range', 'age_range'])
        ->withTrashed()
        ->get();
        return AnimalResource::collection($animals);
    }
    public function create($animal)
    {    
        return Animal::create($animal);
    }

    public function update($id, $updatedDatas)
    {
        $animal = Animal::find($id);
        if ($animal) {
            $animal->update($updatedDatas);
        }
        return $animal;
    }

    public function find($id){
        $animal = Animal::with(['specie', 'gender', 'color', 'coat', 'size_range', 'age_range'])
        ->withTrashed()
        ->findOrFail($id);
        return new AnimalResource($animal);
    }

    public function softDelete($id){
        $animal = Animal::findOrFail($id);
        $animal->delete();  
        return $animal;
    }
}

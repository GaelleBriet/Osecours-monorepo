<?php

namespace App\Repositories;

use App\Contract\AnimalRepositioryInterface;
use App\Models\Animal;

class AnimalRepository extends BaseRepository implements AnimalRepositioryInterface
{
    public function __construct(Animal $animal)
    {
        parent::__construct($animal);
    }
  
    public function create($animal)
    {
        return Animal::create($animal);
    }

    public function update($id,$updatedDatas)
    {
        $animal = Animal::find($id);
        foreach($updatedDatas as $key => $value){
            switch($key){
                case 'name':
                    $animal->name = $value;
                    break;
                    case 'name':
                        $animal->name = $value;
                        break;

            }
        }
    }
}

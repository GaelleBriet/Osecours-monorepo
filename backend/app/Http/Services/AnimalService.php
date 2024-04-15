<?php 

namespace App\Http\Services;

use App\Contract\AnimalRepositioryInterface;

class AnimalService {

    protected AnimalRepositioryInterface $animals;

    public function __construct(AnimalRepositioryInterface $animalRepositiory){
        $this->animals = $animalRepositiory;
    }

    public function getAll(){
       return $this->animals->all();
    }    

    public function createOrUpdate($animal){
        $this->animals->createOrUpdate($animal);
    }
   
}
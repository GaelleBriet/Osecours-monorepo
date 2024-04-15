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

    public function create($animal){
        $this->animals->create($animal);
    }

    public function update($id,$updatedDatas){
        $this->animals->update($id,$updatedDatas);
    }
   
}
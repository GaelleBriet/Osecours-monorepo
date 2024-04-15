<?php 

namespace App\Http\Services;

use App\Contract\AnimalRepositoryInterface;
use App\Repositories\AnimalRepository;

class AnimalService {

    protected AnimalRepositoryInterface $animals;

    public function __construct(AnimalRepository $animalRepositiory){
        $this->animals = $animalRepositiory;
    }

    public function getAll(){
       return $this->animals->all();
    }    

    public function create($animal){
       return $this->animals->create($animal);
    }

    public function update($id,$updatedDatas){
        return $this->animals->update($id,$updatedDatas);
    }
    
    public function softDelete($id){
        return $this->animals->softDelete($id);
    }
}
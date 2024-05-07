<?php

namespace App\Repositories;

use App\Contract\IdentificationRepositoryInterface;
use App\Models\Association;
use App\Models\Identification;
use App\Models\Role;
use App\Models\User;

class IdentificationRepository extends BaseRepository implements  IdentificationRepositoryInterface
{
    public function __construct(Identification $identification)
    {
        parent::__construct($identification);
    }

    public function all(){
        return Identification::all();
    }

    public function find($id){
        return Identification::findOrFail($id);
    }

    public function create(array $data){
        return Identification::create($data);
    }
    
    public function update($id,$updatedDatas){
        $currentIdentitification = Identification::findOrFail($id);
        $currentIdentitification->update($updatedDatas);
        return $currentIdentitification->save();
    }

   
}

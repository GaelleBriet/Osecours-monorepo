<?php 

namespace App\Http\Services;

use App\Contract\AssociationRepositoryInterface;
use App\Repositories\AssociationRepository;
use Illuminate\Support\Facades\Date;

class AssociationService {

    protected AssociationRepositoryInterface $association;

    public function __construct(AssociationRepository $associationRepo){
        $this->association = $associationRepo;
    }

    public function getAll(){
       return $this->association->all();
    }    

    public function getById($id){
        return $this->association->find($id);
    }

    public function create($request){        
       return $this->association->create($request);
    }

    public function update($id,$updatedDatas){
        return $this->association->update($id,$updatedDatas);
    }
    
    public function softDelete($id){
        return $this->association->softDelete($id);
    }

}
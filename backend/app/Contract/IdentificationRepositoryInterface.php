<?php

namespace App\Contract;


interface IdentificationRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);
    
    public function update($id,array $updatedDatas);
}

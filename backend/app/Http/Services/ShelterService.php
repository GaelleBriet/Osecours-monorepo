<?php

namespace App\Http\Services;

use App\Contract\ShelterRepositoryInterface;
use App\Repositories\ShelterRepository;

class ShelterService
{
    protected ShelterRepositoryInterface $shelter;

    public function __construct(ShelterRepositoryInterface $shelterRepo)
    {
        $this->shelter = $shelterRepo;
    }

    public function getAll()
    {
        return $this->shelter->all();
    }

    public function getById($id)
    {
        return $this->shelter->find($id);
    }

    public function create($request)
    {
        return $this->shelter->create($request);
    }

    public function update($id, $updatedDatas)
    {
        return $this->shelter->update($id, $updatedDatas);
    }

    public function softDelete($id)
    {
        return $this->shelter->softDelete($id);
    }
}

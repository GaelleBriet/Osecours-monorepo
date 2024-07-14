<?php

namespace App\Http\Services;

use App\Contract\AnimalRepositoryInterface;
use App\Contract\IdentificationRepositoryInterface;
use App\Enum\IdentificationTypeEnum;
use App\Repositories\AnimalRepository;
use App\Repositories\IdentificationRepository;
use Illuminate\Support\Facades\Date;

class AnimalService
{
    protected AnimalRepositoryInterface $animals;

    protected IdentificationRepositoryInterface $identifications;

    public function __construct(AnimalRepository $animalRepository, IdentificationRepository $identificationRepository)
    {
        $this->animals = $animalRepository;
        $this->identifications = $identificationRepository;
    }

    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $this->animals->all();
    }

    public function getById($id)
    {
        return $this->animals->find($id);
    }

    public function create($request)
    {

        $type = null;
        if (array_key_exists('number', $request)) {
            $type = $this->getIdentityType($request['number']);
        }

        $animalCreated = $this->animals->create($request);
        $this->identifications->create([
            'type' => $type,
            'number' => ! is_null($type) ? $request['number'] : null,
            'date' => Date::now(),
            'animal_id' => $animalCreated->id,
        ]);

        return $animalCreated;
    }

    public function update($id, $updatedDatas)
    {

        $animalsData = collect($updatedDatas)->except('number')->toArray();
        $identificationData = collect($updatedDatas)->only('number')->toArray();
        $animal = $this->animals->update($id, $animalsData);
        $identificationData['type'] = $this->getIdentityType($identificationData['number']);

        $animal->identification()->update($identificationData);

        return $animal;
    }

    public function softDelete($id)
    {
        return $this->animals->softDelete($id);
    }

    public function getIdentityType($numberIdentity)
    {
        $type = IdentificationTypeEnum::TATOO->value;
        if (strlen($numberIdentity) == 15) {
            $type = IdentificationTypeEnum::CHIP->value;
        }

        return $type;
    }
}

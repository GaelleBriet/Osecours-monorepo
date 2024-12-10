<?php

namespace Tests\Unit\Services;

use App\Http\Services\AnimalService;
use App\Http\Resources\AnimalResource;
use App\Repositories\AnimalRepository;
use App\Repositories\IdentificationRepository;
use App\Enum\IdentificationTypeEnum;
use App\Models\Animal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Mockery;
use Tests\TestCase;

class AnimalServiceTest extends TestCase
{
    protected $animalRepositoryMock;
    protected $identificationRepositoryMock;
    protected $animalService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animalRepositoryMock = Mockery::mock(AnimalRepository::class);
        $this->identificationRepositoryMock = Mockery::mock(IdentificationRepository::class);

        $this->animalService = new AnimalService(
            $this->animalRepositoryMock,
            $this->identificationRepositoryMock
        );
    }

    public function test_get_all_animals()
    {
        $animals = Collection::make([new Animal, new Animal]);
        $animalResources = AnimalResource::collection($animals);
        $this->animalRepositoryMock->shouldReceive('all')->once()->andReturn($animalResources);

        $result = $this->animalService->getAll();

        $this->assertEquals($animalResources, $result);
    }

    public function test_get_animal_by_id()
    {
        $animal = new Animal;
        $animalResource = new AnimalResource($animal);
        $this->animalRepositoryMock->shouldReceive('find')->with(1)->once()->andReturn($animalResource);

        $result = $this->animalService->getById(1);

        $this->assertEquals($animalResource, $result);
    }

    public function test_create_animal()
    {
        $request = [
            'name' => 'Shaggy',
            'number' => '123456789012345',
        ];

        $animal = new Animal;
        $animal->id = 1;
        $this->animalRepositoryMock->shouldReceive('create')->with($request)->once()->andReturn($animal);

        $identificationData = [
            'type' => IdentificationTypeEnum::CHIP->value,
            'number' => '123456789012345',
            'date' => Date::now(),
            'animal_id' => $animal->id,
        ];
        $this->identificationRepositoryMock->shouldReceive('create')->with(Mockery::on(function ($data) use ($identificationData) {
            return $data['type'] === $identificationData['type'] &&
                $data['number'] === $identificationData['number'] &&
                $data['animal_id'] === $identificationData['animal_id'];
        }))->once();

        $result = $this->animalService->create($request);

        $this->assertEquals($animal, $result);
    }

    public function test_update_animal()
    {
        $updatedDatas = [
            'name' => 'Shaggy',
            'number' => '123456789012345',
        ];

        $animal = Mockery::mock(Animal::class)->makePartial();
        $animal->shouldReceive('identification->update')->once();

        $this->animalRepositoryMock->shouldReceive('update')->with(1, ['name' => 'Shaggy'])->once()->andReturn($animal);

        $result = $this->animalService->update(1, $updatedDatas);

        $this->assertEquals($animal, $result);
    }

    public function test_soft_delete_animal()
    {
        $animal = new Animal;
        $this->animalRepositoryMock->shouldReceive('softDelete')->with(1)->once()->andReturn($animal);

        $result = $this->animalService->softDelete(1);

        $this->assertEquals($animal, $result);
    }
}

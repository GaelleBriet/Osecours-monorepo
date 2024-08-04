<?php

namespace Tests\Unit\Services;

use App\Http\Services\ShelterService;
use App\Http\Resources\ShelterResource;
use App\Contract\ShelterRepositoryInterface;
use App\Models\Shelter;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;

class ShelterServiceTest extends TestCase
{
    protected $shelterRepositoryMock;
    protected $shelterService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shelterRepositoryMock = Mockery::mock(ShelterRepositoryInterface::class);
        $this->shelterService = new ShelterService($this->shelterRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_all_shelters()
    {
        $this->shelterRepositoryMock->shouldReceive('all')->andReturn(collect());

        $result = $this->shelterService->getAll();

        $this->assertEmpty($result);
    }

    public function test_get_a_shelter_by_id()
    {
        $shelter = Shelter::factory()->make();

        $this->shelterRepositoryMock->shouldReceive('find')
            ->once()
            ->with($shelter->id)
            ->andReturn($shelter);

        $result = $this->shelterService->getById($shelter->id);

        $this->assertEquals($shelter, $result);
    }

    public function test_create_a_shelter()
    {
        $data = ['name' => 'Shelter Name', 'description' => 'Description'];
        $shelter = Shelter::factory()->make($data);

        $this->shelterRepositoryMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($shelter);

        $result = $this->shelterService->create($data);

        $this->assertEquals($shelter, $result);
    }

    public function test_update_a_shelter()
    {
        $id = 1;
        $updatedData = ['name' => 'Updated Name'];
        $shelter = Shelter::factory()->make($updatedData);

        $this->shelterRepositoryMock->shouldReceive('update')
            ->once()
            ->with($id, $updatedData)
            ->andReturn($shelter);

        $result = $this->shelterService->update($id, $updatedData);

        $this->assertEquals($shelter, $result);
    }

    public function test_soft_delete_a_shelter()
    {
        $id = 1;
        $shelter = Shelter::factory()->make(['id' => $id]);

        $this->shelterRepositoryMock->shouldReceive('softDelete')
            ->once()
            ->with($id)
            ->andReturn($shelter);

        $result = $this->shelterService->softDelete($id);

        $this->assertEquals($shelter, $result);
    }
}

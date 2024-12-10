<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ShelterController;
use App\Http\Requests\ShelterRequest;
use App\Models\Shelter;
use App\Http\Services\ShelterService;
use App\Http\Services\ErrorService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class ShelterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $shelterServiceMock;
    protected $errorServiceMock;
    protected $shelterController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shelterServiceMock = Mockery::mock(ShelterService::class);
        $this->errorServiceMock = Mockery::mock(ErrorService::class);
        $this->shelterController = new ShelterController($this->shelterServiceMock, $this->errorServiceMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    
    public function test_get_all_shelters()
    {
        $shelters = Shelter::factory()->count(3)->make();

        $this->shelterServiceMock->shouldReceive('getAll')
            ->once()
            ->andReturn($shelters);

        $response = $this->shelterController->getAll();

        $this->assertEquals($shelters, $response);
    }

    public function test_store_shelter()
    {
        $shelter = Shelter::factory()->make()->toArray();
    
        // Mock the ShelterRequest
        $request = Mockery::mock(ShelterRequest::class);
        $request->shouldReceive('validated')
                ->once()
                ->andReturn($shelter);
    
        $this->app->instance(ShelterRequest::class, $request);
    
        // Expect the create method on the service to be called and return a new Shelter
        $this->shelterServiceMock->shouldReceive('create')
                ->once()
                ->with($shelter)
                ->andReturn(new Shelter($shelter));
    
        // Call the controller method
        $response = $this->shelterController->store($request);
    
        // Assertions
        $this->assertInstanceOf(Shelter::class, $response);
        $this->assertEquals($shelter['name'], $response->name);
    }

    public function test_show_shelter()
    {
        $shelter = Shelter::factory()->make();
        $shelter->id = 1;

        $this->shelterServiceMock->shouldReceive('getById')
            ->once()
            ->with($shelter->id)
            ->andReturn($shelter);

        $response = $this->shelterController->show($shelter->id);

        $this->assertEquals($shelter, $response);
    }

    public function test_update_shelter()
    {
        $shelter = Shelter::factory()->make();
        $shelter->id = 1; 
        $updatedData = Shelter::factory()->make()->toArray();
    
        $request = Mockery::mock(ShelterRequest::class);
        $request->shouldReceive('validated')
                ->once()
                ->andReturn($updatedData);
    
        $this->app->instance(ShelterRequest::class, $request);
    
        $this->shelterServiceMock->shouldReceive('update')
            ->once()
            ->with((string)$shelter->id, $updatedData)
            ->andReturn(new Shelter($updatedData));
    
        $response = $this->shelterController->update($request, (string)$shelter->id);
    
        $this->assertInstanceOf(Shelter::class, $response);
        $this->assertEquals($updatedData['name'], $response->name);
    }
    

    public function test_destroy_shelter()
    {
        $shelter = Shelter::factory()->make();

        $this->shelterServiceMock->shouldReceive('softDelete')
            ->once()
            ->with($shelter->id)
            ->andReturn($shelter);

        $response = $this->shelterController->destroy($shelter->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('L\'shelter a été supprimé avec succès.', $response->getData()->message);
        $this->assertEquals($shelter->toArray(), (array)$response->getData()->shelter);
    }
}

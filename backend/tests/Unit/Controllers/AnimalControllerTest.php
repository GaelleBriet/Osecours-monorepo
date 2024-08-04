<?php

namespace Tests\Unit\Controllers;

use App\Http\Services\AnimalService;
use App\Http\Resources\AnimalResource;
use App\Http\Services\ErrorService;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class AnimalControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $animalServiceMock;
    protected $errorServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animalServiceMock = Mockery::mock(AnimalService::class);
        $this->errorServiceMock = Mockery::mock(ErrorService::class);

        $this->app->instance(AnimalService::class, $this->animalServiceMock);
        $this->app->instance(ErrorService::class, $this->errorServiceMock);
    }

    public function test_get_all()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Persist the animals to the db
        $animals = Animal::factory()->count(2)->make();

        // Convert animals to a resource collection
        $animalResources = AnimalResource::collection($animals);
        
        // Mock the service call
        $this->animalServiceMock->shouldReceive('getAll')->once()->andReturn($animalResources);

        // Perform the GET request
        $response = $this->getJson('/api/animals/all');

        // Check the response status and structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name', 'description', 'birth_date', 'cats_friendly', 'dogs_friendly',
                        'children_friendly', 'age', 'behavioral_comment', 'sterilized', 'deceased',
                        'specie_id', 'breed_id', 'gender_id', 'color_id', 'coat_id', 'sizerange_id', 'agerange_id',
                    ],
                ],
            ]);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $request = [
            'name' => 'Shaggy',
            'specie_id' => 1,
        ];

        $animal = new Animal($request);
        $this->animalServiceMock->shouldReceive('create')->once()->andReturn($animal);

        $response = $this->postJson('/api/animals', $request);

        $response->assertStatus(200)
            ->assertJsonFragment($request);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        //make() creates a new model instance without persisting it to the database.
        $animal = Animal::factory()->make();

        $animalResource = new AnimalResource($animal);
        $this->animalServiceMock->shouldReceive('getById')->with(1)->once()->andReturn($animalResource);

        $response = $this->getJson('/api/animals/1');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $animal->id,
                'name' => $animal->name,
            ]);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    
        // Persist the original animal to the database
        $originalAnimal = Animal::factory()->create(['name' => 'Original Shaggy']);
    
        // Request data to update the animal
        $request = [
            'name' => 'Updated Shaggy',
        ];
    
        // Mock the service call to return an updated animal instance
        // fresh() reloads the model from the database, discarding any in-memory changes
        $updatedAnimal = $originalAnimal->fresh();
        $updatedAnimal->name = 'Updated Shaggy';
    
        $this->animalServiceMock->shouldReceive('update')->with($originalAnimal->id, $request)->once()->andReturn($updatedAnimal);
    
        // PUT request
        $response = $this->putJson("/api/animals/{$originalAnimal->id}", $request);
    
        // Check both response status and structure
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Shaggy']);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $animal = Animal::factory()->create();
        $this->animalServiceMock->shouldReceive('softDelete')->with(1)->once()->andReturn($animal);

        $response = $this->deleteJson('/api/animals/1');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'L\'animal a été supprimé avec succès.',
            ]);
    }
}

<?php

namespace Tests\Unit\Services;

use App\Http\Services\UserService;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_create_user()
    {
        $repositoryMock = Mockery::mock(UserRepository::class);
        $userService = new UserService($repositoryMock);

        $validatedData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '123456789',
            'existing_cat_count' => 2,
            'existing_children_count' => 1,
            'existing_dog_count' => 0,
            'email' => 'john@example.com',
            'password' => 'password',
        ];
        $repositoryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) use ($validatedData) {
                return $arg['first_name'] === $validatedData['first_name']
                    && $arg['last_name'] === $validatedData['last_name']
                    && $arg['phone'] === $validatedData['phone']
                    && $arg['existing_cat_count'] === $validatedData['existing_cat_count']
                    && $arg['existing_children_count'] === $validatedData['existing_children_count']
                    && $arg['existing_dog_count'] === $validatedData['existing_dog_count']
                    && $arg['email'] === $validatedData['email']
                    && Hash::check($validatedData['password'], $arg['password']);
            }))
            ->andReturn(new User($validatedData));

        $result = $userService->create($validatedData);
        $this->assertEquals($validatedData['first_name'], $result->first_name);
        $this->assertEquals($validatedData['last_name'], $result->last_name);
        $this->assertEquals($validatedData['phone'], $result->phone);
        $this->assertEquals($validatedData['existing_cat_count'], $result->existing_cat_count);
        $this->assertEquals($validatedData['existing_children_count'], $result->existing_children_count);
        $this->assertEquals($validatedData['existing_dog_count'], $result->existing_dog_count);
        $this->assertEquals($validatedData['email'], $result->email);
    }
}

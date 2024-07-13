<?php

namespace Tests\Unit\Models;

use App\Contract\UserRepositoryInterface;
use App\Models\User;
use App\Http\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;
    protected $userRepository;


    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = \Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepository);
    }

    /**
     * A basic feature test example.
     */
    public function test_user_can_be_created(): void
    {
        $userData= [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '123456789',
            'existing_cat_count' => 2,
            'existing_children_count' => 1,
            'existing_dog_count' => 0,
            'email' => 'johndoe@mail.fr',
            'password' => 'password',
        ];

        $this->userRepository->shouldReceive('create')
            ->once()
            ->with(\Mockery::on(function ($arg) use ($userData) {
                return $arg instanceof User
                    && $arg['first_name'] === $userData['first_name']
                    && $arg['last_name'] === $userData['last_name']
                    && $arg['phone'] === $userData['phone']
                    && $arg['existing_cat_count'] === $userData['existing_cat_count']
                    && $arg['existing_children_count'] === $userData['existing_children_count']
                    && $arg['existing_dog_count'] === $userData['existing_dog_count']
                    && $arg['email'] === $userData['email']
                    && Hash::check($userData['password'], $arg['password']);
            }))
            ->andReturn(new User($userData));
        dd($userData);
        $result = $this->userService->create($userData);

        $this->assertInstanceOf(User::class, $result);

        //$user = $this->userService->create($userData);

    }
}

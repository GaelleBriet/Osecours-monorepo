<?php

namespace Tests\Unit\Models;

use App\Models\Animal;
use App\Models\Association;
use App\Models\Person;
use App\Models\Role;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '123456789',
            'existing_cat_count' => 2,
            'existing_children_count' => 1,
            'existing_dog_count' => 0,
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ];

        $user = new User($userData);
        $user->save();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['first_name'], $user->first_name);
        $this->assertEquals($userData['last_name'], $user->last_name);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertTrue(Hash::check('password123', $user->password));

        // Verify that the user was actually saved to the database
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }

    public function test_fillable_attributes()
    {
        $fillable = [
            'first_name', 'last_name', 'phone', 'existing_cat_count',
            'existing_children_count', 'existing_dog_count', 'email', 'password',
        ];

        $user = new User;
        $this->assertEquals($fillable, $user->getFillable());
    }

    public function test_user_has_person_relation()
    {
        $user = new User();
        $user->id = 1;
        $person = Person::factory()->create(['personable_id' => $user->id, 'personable_type' => User::class]);
        $this->assertInstanceOf(MorphOne::class, $user->person());
        $this->assertEquals($user->id, $person->personable_id);
    }

    public function test_user_has_associations_relation()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $association = Association::factory()->create();

        $user->associations()->attach($association, ['role_id' => $role->id]);
        $user = $user->fresh();

        $this->assertTrue($user->associations->contains($association));
        $this->assertEquals($role->id, $user->associations->first()->pivot->role_id);
        $this->assertTrue($user->associations->first()->is($association));
        $this->assertTrue($association->users->contains($user));
    }

    public function test_user_has_roles_relation()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $association = Association::factory()->create();

        $user->roles()->attach($role, ['association_id' => $association->id]);
        $user = $user->fresh();

        $this->assertTrue($user->roles->contains($role));
        $this->assertEquals($association->id, $user->roles->first()->pivot->association_id);
    }

    public function test_user_has_animals_relation()
    {
        $user = User::factory()->create();
        $animal = Animal::factory()->create();
        $shelter = Shelter::factory()->create();

        $user->animals()->attach($animal, ['shelter_id' => $shelter->id]);
        $user = $user->fresh();

        $this->assertTrue($user->animals->contains($animal));
    }

    public function test_user_has_shelters_relation()
    {
        $user = User::factory()->create();
        $animal = Animal::factory()->create();
        $shelter = Shelter::factory()->create();

        $user->shelters()->attach($shelter, ['animal_id' => $animal->id]);
        $user = $user->fresh();

        $this->assertTrue($user->shelters->contains($shelter));
    }

    public function test_soft_delete()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertSoftDeleted($user);
    }
}

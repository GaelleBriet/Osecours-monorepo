<?php

namespace Tests\Unit\Models;

use App\Models\Association;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRelationsStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_belongs_to_many_associations()
    {
        $user = new User();
        $associations = $user->associations();
        $this->assertInstanceOf(BelongsToMany::class, $user->associations());

        $this->assertEquals(Association::class, get_class($associations->getRelated()));
        $this->assertEquals('association_role_user', $associations->getTable());
        $this->assertEquals('association_role_user.association_id', $associations->getQualifiedRelatedPivotKeyName());
        $this->assertContains('role_id', $associations->getPivotColumns());
        $this->assertTrue($associations->withTimestamps);
    }

    public function test_user_roles()
    {
        $user = new User();
        $roles = $user->roles();
        $this->assertInstanceOf(BelongsToMany::class, $user->roles());

        $this->assertEquals('association_role_user', $roles->getTable());
        $this->assertEquals('association_role_user.user_id', $roles->getQualifiedForeignPivotKeyName());
        $this->assertContains('association_id', $roles->getPivotColumns());
        $this->assertTrue($roles->withTimestamps);
    }

    public function test_user_animals()
    {
        $user = new User();
        $animals = $user->animals();
        $this->assertInstanceOf(BelongsToMany::class, $user->animals());

        $this->assertEquals('animal_shelter_user', $animals->getTable());
        $this->assertEquals('animal_shelter_user.user_id', $animals->getQualifiedForeignPivotKeyName());
        $this->assertContains('animal_id', $animals->getPivotColumns());
        $this->assertTrue($animals->withTimestamps);
    }
}

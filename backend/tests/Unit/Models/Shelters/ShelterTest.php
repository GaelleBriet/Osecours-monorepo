<?php

namespace Tests\Unit\Models\Shelters;

use App\Models\Shelter;
use App\Models\Person;
use App\Models\Association;
use App\Models\User;
use App\Models\Animal;
use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShelterTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_has_fillable_attributes()
    {
        $fillable = ['name', 'description', 'phone', 'email', 'siret'];

        $shelter = new Shelter;
        $this->assertEquals($fillable, $shelter->getFillable());
    }
    
    public function test_it_has_one_person()
    {
        $person = Person::factory()->create();
        $shelter = Shelter::factory()->create();
        $shelter->person()->save($person);

        $this->assertInstanceOf(Person::class, $shelter->person);
        $this->assertEquals($person->id, $shelter->person->id);
    }
    
    public function test_it_belongs_to_many_associations()
    {
        $association = Association::factory()->create();
        $shelter = Shelter::factory()->create();
        $shelter->associations()->attach($association, [
            'begin_date' => now(),
            'end_date' => null,
        ]);

        $this->assertTrue($shelter->associations->contains($association));
        $this->assertEquals(1, $shelter->associations->count());
    }
    
    public function test_it_belongs_to_many_users()
    {
        $user = User::factory()->create();
        $shelter = Shelter::factory()->create();
        $animal = Animal::factory()->create();
        $shelter->users()->attach($user, [
            'animal_id' => $animal->id,
        ]);

        $this->assertTrue($shelter->users->contains($user));
        $this->assertEquals(1, $shelter->users->count());
    }
    
    public function test_it_belongs_to_many_animals()
    {
        $animal = Animal::factory()->create();
        $shelter = Shelter::factory()->create();
        $user = User::factory()->create();
        $shelter->animals()->attach($animal, [
            'user_id' => $user->id,
        ]);
        
        $this->assertTrue($shelter->animals->contains($animal));
        $this->assertEquals(1, $shelter->animals->count());
    }
    
    public function test_it_belongs_to_many_documents()
    {
        $document = Document::factory()->create();
        $shelter = Shelter::factory()->create();
        $shelter->documents()->attach($document);

        $this->assertTrue($shelter->documents->contains($document));
        $this->assertEquals(1, $shelter->documents->count());
    }
    
    public function test_it_can_retrieve_documents()
    {
        $shelter = Shelter::factory()->create();
        $document = Document::factory()->create();
        $shelter->documents()->attach($document);

        $documents = $shelter->getDocuments();

        $this->assertTrue($documents->contains($document));
        $this->assertEquals(1, $documents->count());
    }
}

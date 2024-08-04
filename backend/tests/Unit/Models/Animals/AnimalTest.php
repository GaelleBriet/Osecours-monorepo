<?php

namespace Tests\Unit\Models\Animals;

use App\Models\Animal;
use App\Models\Gender;
use App\Models\Breed;
use App\Models\Specie;
use App\Models\Coat;
use App\Models\Color;
use App\Models\Document;
use App\Models\SizeRange;
use App\Models\AgeRange;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimalTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_fillable_attributes()
    {
        $fillable = [
            'name', 'description', 'birth_date', 'cats_friendly', 'dogs_friendly',
            'children_friendly', 'age', 'behavioral_comment', 'sterilized', 'deceased',
            'specie_id', 'breed_id', 'gender_id', 'color_id', 'coat_id', 'sizerange_id', 'agerange_id',
        ];

        $animal = new Animal;
        $this->assertEquals($fillable, $animal->getFillable());
    }

    public function test_it_belongs_to_a_gender()
    {
        $gender = Gender::factory()->create();
        $animal = Animal::factory()->create(['gender_id' => $gender->id]);

        $this->assertInstanceOf(Gender::class, $animal->gender);
        $this->assertEquals($gender->id, $animal->gender->id);
    }

    public function test_it_belongs_to_a_breed()
    {
        $breed = Breed::factory()->create();
        $animal = Animal::factory()->create(['breed_id' => $breed->id]);

        $this->assertInstanceOf(Breed::class, $animal->breed);
        $this->assertEquals($breed->id, $animal->breed->id);
    }

    public function test_it_belongs_to_a_specie()
    {
        $specie = Specie::factory()->create();
        $animal = Animal::factory()->create(['specie_id' => $specie->id]);

        $this->assertInstanceOf(Specie::class, $animal->specie);
        $this->assertEquals($specie->id, $animal->specie->id);
    }

    public function test_it_belongs_to_a_coat()
    {
        $coat = Coat::factory()->create();
        $animal = Animal::factory()->create(['coat_id' => $coat->id]);

        $this->assertInstanceOf(Coat::class, $animal->coat);
        $this->assertEquals($coat->id, $animal->coat->id);
    }

    public function test_it_belongs_to_a_color()
    {
        $color = Color::factory()->create();
        $animal = Animal::factory()->create(['color_id' => $color->id]);

        $this->assertInstanceOf(Color::class, $animal->color);
        $this->assertEquals($color->id, $animal->color->id);
    }

    public function test_it_belongs_to_a_size_range()
    {
        $sizeRange = SizeRange::factory()->create();
        $animal = Animal::factory()->create(['sizerange_id' => $sizeRange->id]);

        $this->assertInstanceOf(SizeRange::class, $animal->sizeRange);
        $this->assertEquals($sizeRange->id, $animal->sizeRange->id);
    }

    public function test_it_belongs_to_an_age_range()
    {
        $ageRange = AgeRange::factory()->create();
        $animal = Animal::factory()->create(['agerange_id' => $ageRange->id]);

        $this->assertInstanceOf(AgeRange::class, $animal->ageRange);
        $this->assertEquals($ageRange->id, $animal->ageRange->id);
    }

    public function test_it_can_retrieve_documents()
    {
        $animal = Animal::factory()->create();
        $document = Document::factory()->create();
        $animal->documents()->attach($document);

        $this->assertTrue($animal->documents->contains($document));
        $this->assertEquals(1, $animal->documents->count());
    }

    public function test_it_can_get_specie_name()
    {
        $specie = Specie::factory()->create(['name' => 'Canine']);
        $animal = Animal::factory()->create(['specie_id' => $specie->id]);

        $this->assertEquals('Canine', $animal->specie_name);
    }

    public function test_it_can_get_gender_name()
    {
        $gender = Gender::factory()->create(['name' => 'Male']);
        $animal = Animal::factory()->create(['gender_id' => $gender->id]);

        $this->assertEquals('Male', $animal->gender_name);
    }

}
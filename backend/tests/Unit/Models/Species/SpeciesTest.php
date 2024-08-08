<?php

namespace Tests\Unit\Models\Species;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Color;
use App\Models\Specie as Species;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpeciesTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseTransactions;

    //    public function test_can_create_cat_and_dog_species()
    //    {
    //        $speciesData = [
    //            [
    //                'name' => 'Cat',
    //                'description' => 'A small domesticated carnivorous mammal with soft fur, a short snout, and retractile claws. It is widely kept as a pet or for catching mice, and many breeds have been developed.',
    //            ],
    //            [
    //                'name' => 'Dog',
    //                'description' => 'A domesticated carnivorous mammal that typically has a long snout, an acute sense of smell, and a barking, howling, or whining voice.',
    //            ],
    //        ];
    //
    //        foreach ($speciesData as $data) {
    //            $species = new Species($data);
    //            $species->save();
    //
    //            $this->assertInstanceOf(Species::class, $species);
    //            $this->assertEquals($data['name'], $species->name);
    //            $this->assertEquals($data['description'], $species->description);
    //
    //            $this->assertDatabaseHas('species', $data);
    //        }
    //
    //        $this->assertEquals(2, Species::count());
    //
    //        $this->assertTrue(Species::where('name', 'Cat')->exists());
    //        $this->assertTrue(Species::where('name', 'Dog')->exists());
    //
    //        // Try to create a third species
    //        $extraSpecies = new Species([
    //            'name' => 'Bird',
    //            'description' => 'A warm-blooded egg-laying vertebrate animal distinguished by the possession of feathers, wings, a beak, and typically by being able to fly.',
    //        ]);
    //        $extraSpecies->save();
    //
    //        // Verify that the third species was not added
    //        $this->assertEquals(2, Species::count());
    //        $this->assertFalse(Species::where('name', 'Bird')->exists());
    //    }

    public function test_fillable_attributes()
    {
        $fillable = [
            'name', 'description',
        ];

        $species = new Species;
        $this->assertEquals($fillable, $species->getFillable());
    }

    public function test_species_has_many_animals()
    {
        $species = Species::where('name', 'Dog')->first();
        $breed = Breed::factory()->create(['specie_id' => $species->id]);
        $animal = Animal::factory()->create(['specie_id' => $species->id, 'breed_id' => $breed->id]);
        $this->assertInstanceOf(Animal::class, $species->animals->first());
        $this->assertEquals($species->id, $animal->specie_id);
    }

    public function test_species_has_many_breeds()
    {
        $species = Species::where('name', 'Dog')->first();
        $breed = Breed::factory()->create(['specie_id' => $species->id]);
        $this->assertInstanceOf(Breed::class, $species->breeds->first());
        $this->assertEquals($species->id, $breed->specie_id);
    }

    public function test_species_has_colors_relation()
    {
        $species = Species::where('name', 'Dog')->first();
        $color = Color::factory()->create();
        $species->colors()->attach($color);
        $this->assertInstanceOf(BelongsToMany::class, $species->colors());
        $this->assertInstanceOf(Color::class, $species->colors->first());
    }
}

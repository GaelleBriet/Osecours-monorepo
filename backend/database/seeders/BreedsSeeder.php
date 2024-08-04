<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\Specie;

class BreedsSeeder extends BaseSeeder
{
    public function run(): void
    {
        $dogBreeds = json_decode(file_get_contents(database_path('data/dog_breeds.json')), true);
        $catBreeds = json_decode(file_get_contents(database_path('data/cat_breeds.json')), true);

        $dogSpecie = Specie::where('name', 'Dog')->first();
        $catSpecie = Specie::where('name', 'Cat')->first();

        foreach ($dogBreeds as $breed) {
            Breed::factory()->create([
                'name' => $breed,
                'specie_id' => $dogSpecie->id,
            ]);
        }

        foreach ($catBreeds as $breed) {
            Breed::factory()->create([
                'name' => $breed,
                'specie_id' => $catSpecie->id,
            ]);
        }
    }
}

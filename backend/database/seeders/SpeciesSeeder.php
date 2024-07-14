<?php

namespace Database\Seeders;

use App\Models\Specie;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends BaseSeeder
{
    public function run(): void
    {
        $species = ['Cat', 'Dog', 'Other'];

        foreach ($species as $specie) {
            Specie::factory()->create([
                'name' => $specie,
                'description' => $this->faker->sentence(5),
            ]);
        }
    }
}

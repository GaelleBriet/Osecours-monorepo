<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Healthcare;
use App\Models\Identification;
use Illuminate\Database\Seeder;

class HealthcareSeeder extends BaseSeeder
{
    public function run(): void
    {
        $animals = Animal::all();

        foreach ($animals as $animal) {
            Healthcare::factory()->create([
                'animal_id' => $animal->id,
            ]);
        }
    }
}

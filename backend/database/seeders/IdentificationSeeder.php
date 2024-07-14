<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Identification;

class IdentificationSeeder extends BaseSeeder
{
    public function run(): void
    {
        $animals = Animal::all();

        foreach ($animals as $animal) {
            Identification::firstOrCreate(
                ['animal_id' => $animal->id],
                Identification::factory()->make()->toArray()
            );
        }

    }
}

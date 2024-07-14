<?php

namespace Database\Seeders;

use App\Models\Gender;

class GendersSeeder extends BaseSeeder
{
    public function run(): void
    {
        $genders = [
            'Male',
            'Female',
            'Unknown',
        ];

        foreach ($genders as $gender) {
            Gender::factory()->create([
                'name' => $gender,
                'description' => $this->faker->sentence(5),
            ]);
        }
    }
}

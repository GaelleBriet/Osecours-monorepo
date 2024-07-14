<?php

namespace Database\Seeders;

use App\Models\AgeRange;
use Illuminate\Database\Seeder;

class AgeRangesSeeder extends BaseSeeder
{
    public function run(): void
    {
        $ageRanges = ['Baby', 'Junior', 'Adult', 'Senior'];

        foreach ($ageRanges as $ageRange) {
            AgeRange::factory()->create([
                'name' => $ageRange,
                'description' => $this->faker->sentence(5),
            ]);
        }
    }
}

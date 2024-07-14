<?php

namespace Database\Seeders;

use App\Models\SizeRange;
use Illuminate\Database\Seeder;

class SizeRangesSeeder extends BaseSeeder
{
    public function run(): void
    {
        $sizeRanges = ['Small', 'Medium', 'Large', 'Molosse'];

        foreach ($sizeRanges as $sizeRange) {
            SizeRange::factory()->create([
                'name' => $sizeRange,
                'description' => $this->faker->sentence(5),
            ]);
        }
    }
}

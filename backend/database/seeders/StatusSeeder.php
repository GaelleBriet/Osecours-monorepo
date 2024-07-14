<?php

namespace Database\Seeders;

use App\Models\Status;

class StatusSeeder extends BaseSeeder
{
    public function run(): void
    {
        $statuses = [
            'Found',
            'Adoptable',
            'Hosted',
            'Adopted',
            'Dead',
        ];

        foreach ($statuses as $status) {
            Status::factory()->create([
                'name' => $status,
                'description' => $this->faker->sentence(5),
            ]);
        }
    }
}

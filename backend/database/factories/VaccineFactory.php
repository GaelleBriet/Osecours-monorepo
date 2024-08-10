<?php

namespace Database\Factories;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineFactory extends Factory
{
    protected $model = Vaccine::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(),
        ];
    }
}

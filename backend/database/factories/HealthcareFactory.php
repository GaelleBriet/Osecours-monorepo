<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class HealthcareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'report' => $this->faker->sentence(10),
            'weight' => $this->faker->randomFloat(1, 0, 50),
            'size' => $this->faker->randomFloat(1, 0, 50),
        ];
    }
}

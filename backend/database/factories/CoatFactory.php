<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coat>
 */
class CoatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word . $this->faker->numberBetween(1, 100) . $this->faker->randomElement(['*', '/', '-', '+']),
            'description' => $this->faker->sentence,
        ];
    }
}

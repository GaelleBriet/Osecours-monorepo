<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Association>
 */
class AssociationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'siret' => fake()->numberBetween(10000000000000, 99999999999999),
            'description' => fake()->sentence(),
            'rib' => 'FR76'.fake()->numberBetween(1000000000, 9000000000).fake()->numberBetween(1000000000, 9000000000).strtoupper(fake()->randomLetter().fake()->randomLetter().fake()->randomLetter()),
        ];
    }
}

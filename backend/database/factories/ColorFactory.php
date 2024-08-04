<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->colorName(),
            'description' => 'A color is a type of gun dog that retrieves game for a hunter. Generally gun dogs are divided into three primary types: retrievers, flushing spaniels, and pointing breeds.',
        ];
    }
}

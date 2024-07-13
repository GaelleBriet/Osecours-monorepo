<?php

namespace Database\Factories;

use App\Models\Specie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Breed>
 */
class BreedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'specie_id' => Specie::factory(),
            'name' => $this->faker->name(),
            'description' => 'A retriever is a type of gun dog that retrieves game for a hunter. Generally gun dogs are divided into three primary types: retrievers, flushing spaniels, and pointing breeds.',
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Specie;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Animal::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'breed_id' => Breed::factory(),
            'description' => $this->faker->text(),
            'age' => $this->faker->numberBetween(1, 10),
            'specie_id' => Specie::factory(),
        ];
    }
}

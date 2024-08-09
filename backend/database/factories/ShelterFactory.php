<?php

namespace Database\Factories;

use App\Models\Shelter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shelter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'phone' => $this->faker->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'siret' => $this->faker->numerify('##############'),
        ];
    }
}

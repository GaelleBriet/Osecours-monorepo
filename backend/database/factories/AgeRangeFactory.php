<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgeRange>
 */
class AgeRangeFactory extends Factory
{
    protected $ageRanges = [
        'bébé',
        'jeune',
        'adulte',
        'sénior',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement($this->ageRanges);

        return [
            'name' => $name,
            'description' => $this->faker->sentence(10),
        ];
    }
}

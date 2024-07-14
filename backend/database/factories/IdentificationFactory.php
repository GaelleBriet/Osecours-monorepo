<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class IdentificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['chip', 'tatoo']);

        $number = $type === 'chip'
            ? $this->faker->numerify('###############')
            : $this->faker->numerify($this->faker->randomElement(['######', '#######', '########']));

        return [
            'date' => $this->faker->date(),
            'type' => $type,
            'number' => $number,
        ];
    }
}

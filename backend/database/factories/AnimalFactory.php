<?php

namespace Database\Factories;

use App\Models\AgeRange;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Specie;
use App\Models\Gender;
use App\Models\Color;
use App\Models\Coat;
use App\Models\SizeRange;
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
            'description' => $this->faker->sentence(5),
            'birth_date' => $this->faker->date(),
            'cats_friendly' => $this->faker->boolean(),
            'dogs_friendly' => $this->faker->boolean(),
            'children_friendly' => $this->faker->boolean(),
            'age' => $this->faker->numberBetween(1, 10),
            'behavioral_comment' => $this->faker->sentence(5),
            'sterilized' => $this->faker->boolean(),
            'deceased' => $this->faker->boolean(),
            'specie_id' => Specie::factory(),
            'breed_id' => Breed::factory(),
            'gender_id' => Gender::factory(),
            'color_id' => Color::factory(),
            'coat_id' => Coat::factory(),
            'sizerange_id' => SizeRange::factory(),
            'agerange_id' => AgeRange::factory(),
        ];
    }
}

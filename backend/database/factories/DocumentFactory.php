<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mimetype;
use App\Models\Doctype;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filename' => $this->faker->unique()->word . '.' . $this->faker->fileExtension,
            'description' => $this->faker->sentence,
            'size' => $this->faker->numberBetween(1000, 1000000),
            'url' => $this->faker->url,
            'date' => $this->faker->date(),
            'mimetype_id' => Mimetype::factory(),
            'doctype_id' => Doctype::factory(),
        ];
    }
}

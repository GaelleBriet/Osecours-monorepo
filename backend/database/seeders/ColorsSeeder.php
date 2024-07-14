<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Specie;
use Illuminate\Database\Seeder;

class ColorsSeeder extends BaseSeeder
{
    public function run(): void
    {
        $dog_colors = json_decode(file_get_contents(database_path('data/dog_colors.json')), true);
        $cat_colors = json_decode(file_get_contents(database_path('data/cat_colors.json')), true);

        $dogSpecie = Specie::where('name', 'Dog')->first();
        $catSpecie = Specie::where('name', 'Cat')->first();

        // firstOrCreate() => pour éviter les doublons
        // synWithoutDetaching => ajoute la relation sans supprimer les relations existantes
        foreach ($dog_colors as $color) {
            $colorModel = Color::firstOrCreate([
                'name' => $color
            ], [
                'description' => $this->faker->sentence(5),
            ]);
            $colorModel->species()->syncWithoutDetaching($dogSpecie->id);
        }

        foreach ($cat_colors as $color) {
            $colorModel = Color::firstOrCreate([
                'name' => $color
            ], [
                'description' => $this->faker->sentence(5),
            ]);
            $colorModel->species()->syncWithoutDetaching($catSpecie->id);
        }
    }
}

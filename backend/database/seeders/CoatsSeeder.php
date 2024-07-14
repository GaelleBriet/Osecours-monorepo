<?php

namespace Database\Seeders;

use App\Models\Coat;
use App\Models\Specie;
use Illuminate\Database\Seeder;

class CoatsSeeder extends BaseSeeder
{
    public function run(): void
    {

        $dogCoats = json_decode(file_get_contents(database_path('data/dog_coats.json')), true);
        $catCoats = json_decode(file_get_contents(database_path('data/cat_coats.json')), true);

        $dogSpecie = Specie::where('name', 'Dog')->first();
        $catSpecie = Specie::where('name', 'Cat')->first();

        foreach ($dogCoats as $coat) {
            $coatModel = Coat::firstOrCreate(
                ['name' => $coat],
                ['description' => $this->faker->sentence(5)]
            );
            $coatModel->species()->syncWithoutDetaching($dogSpecie->id);
        }

        foreach ($catCoats as $coat) {
            $coatModel = Coat::firstOrCreate(
                ['name' => $coat],
                ['description' => $this->faker->sentence(5)]
            );
            $coatModel->species()->syncWithoutDetaching($catSpecie->id);
        }
    }
}

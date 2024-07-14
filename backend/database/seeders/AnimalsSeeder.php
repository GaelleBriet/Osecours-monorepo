<?php

namespace Database\Seeders;

use App\Models\AgeRange;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Coat;
use App\Models\Color;
use App\Models\Gender;
use App\Models\SizeRange;
use App\Models\Specie;

class AnimalsSeeder extends BaseSeeder
{
    public function run(): void
    {
        $cats = json_decode(file_get_contents(database_path('data/cats.json')), true);
        $dogs = json_decode(file_get_contents(database_path('data/dogs.json')), true);
        $catColorNames = json_decode(file_get_contents(database_path('data/cat_colors.json')), true);
        $dogColorNames = json_decode(file_get_contents(database_path('data/dog_colors.json')), true);
        $catCoatNames = json_decode(file_get_contents(database_path('data/cat_coats.json')), true);
        $dogCoatNames = json_decode(file_get_contents(database_path('data/dog_coats.json')), true);

        $catSpecie = Specie::where('name', 'Cat')->first();
        $dogSpecie = Specie::where('name', 'Dog')->first();

        $catBreeds = Breed::where('specie_id', $catSpecie->id)->pluck('id')->toArray();
        $dogBreeds = Breed::where('specie_id', $dogSpecie->id)->pluck('id')->toArray();

        $genders = Gender::all()->toArray();

        $catColors = Color::whereIn('name', $catColorNames)
            ->whereHas('species', function ($query) use ($catSpecie) {
                $query->where('species.id', $catSpecie->id);
            })
            ->pluck('id')->toArray();
        $dogColors = Color::whereIn('name', $dogColorNames)
            ->whereHas('species', function ($query) use ($dogSpecie) {
                $query->where('species.id', $dogSpecie->id);
            })
            ->pluck('id')->toArray();

        $catCoats = Coat::whereIn('name', $catCoatNames)
            ->whereHas('species', function ($query) use ($catSpecie) {
                $query->where('species.id', $catSpecie->id);
            })
            ->pluck('id')->toArray();
        $dogCoats = Coat::whereIn('name', $dogCoatNames)
            ->whereHas('species', function ($query) use ($dogSpecie) {
                $query->where('species.id', $dogSpecie->id);
            })
            ->pluck('id')->toArray();

        $catSizeRanges = SizeRange::whereNotIn('name', ['Molosse'])->pluck('id')->toArray();
        $dogSizeRanges = SizeRange::pluck('id')->toArray();

        $ageRanges = AgeRange::pluck('id')->toArray();

        foreach ($cats as $cat) {
            Animal::factory()->create([
                'name' => $cat['name'],
                'description' => $cat['description'],
                'birth_date' => $cat['birth_date'],
                'cats_friendly' => $cat['cats_friendly'],
                'dogs_friendly' => $cat['dogs_friendly'],
                'children_friendly' => $cat['children_friendly'],
                'age' => $cat['age'],
                'behavioral_comment' => $cat['behavioral_comment'],
                'sterilized' => $cat['sterilized'],
                'deceased' => $cat['deceased'],
                'specie_id' => $catSpecie->id,
                'breed_id' => $catBreeds[array_rand($catBreeds)],
                'gender_id' => $this->faker->randomElement(Gender::pluck('id')->toArray()),
                'color_id' => $this->faker->randomElement($catColors),
                'coat_id' => $this->faker->randomElement($catCoats),
                'sizerange_id' => $catSizeRanges[array_rand($catSizeRanges)],
                'agerange_id' => $ageRanges[array_rand($ageRanges)],
            ]);
        }

        foreach ($dogs as $dog) {
            Animal::factory()->create([
                'name' => $dog['name'],
                'description' => $dog['description'],
                'birth_date' => $dog['birth_date'],
                'cats_friendly' => $dog['cats_friendly'],
                'dogs_friendly' => $dog['dogs_friendly'],
                'children_friendly' => $dog['children_friendly'],
                'age' => $dog['age'],
                'behavioral_comment' => $dog['behavioral_comment'],
                'sterilized' => $dog['sterilized'],
                'deceased' => $dog['deceased'],
                'specie_id' => $dogSpecie->id,
                'breed_id' => $dogBreeds[array_rand($dogBreeds)],
                'gender_id' => $this->faker->randomElement(Gender::pluck('id')->toArray()),
                'color_id' => $this->faker->randomElement($dogColors),
                'coat_id' => $this->faker->randomElement($dogCoats),
                'sizerange_id' => $dogSizeRanges[array_rand($dogSizeRanges)],
                'agerange_id' => $ageRanges[array_rand($ageRanges)],
            ]);
        }
    }
}

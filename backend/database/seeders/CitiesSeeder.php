<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends BaseSeeder
{
    public function run(): void
    {
        $cities = json_decode(file_get_contents(database_path('data/cities.json')), true);

        foreach ($cities as $city) {
            City::factory()->create([
                'name' => $city['name'],
                'zipcode' => $city['zipcode'],
            ]);
        }
    }
}

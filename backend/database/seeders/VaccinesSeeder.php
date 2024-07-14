<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Seeder;

class VaccinesSeeder extends BaseSeeder
{
    public function run(): void
    {
        $vaccines = json_decode(file_get_contents(database_path('data/vaccines.json')), true);

        foreach ($vaccines as $vaccine) {
            Vaccine::firstOrCreate([
                'name' => $vaccine['name'],
            ], [
                'description' => $vaccine['description'],
            ]);
        }
    }
}

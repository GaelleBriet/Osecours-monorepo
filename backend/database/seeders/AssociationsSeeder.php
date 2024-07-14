<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Address;
use App\Models\City;
use App\Models\Person;
use App\Models\Role;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Association;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class AssociationsSeeder extends BaseSeeder
{
    public function run(): void
    {
        $assocations = json_decode(file_get_contents(database_path('data/associations.json')), true);
        $shelters = json_decode(file_get_contents(database_path('data/shelters.json')), true);
        $addresses = json_decode(file_get_contents(database_path('data/address.json')), true);
        $cities = json_decode(file_get_contents(database_path('data/cities.json')), true);

        foreach ($cities as $city) {
            City::firstOrCreate([
                'name' => $city['name'],
                'zipcode' => $city['zipcode']
            ]);
        }

        foreach ($assocations as $index => $association) {

            $associationCreated = Association::factory()->create([
                "name" => $association['name'],
                "description" => $association['description'],
                "siret" => $association['siret'],
                "rib" => $association['rib'],
            ]);

            $shelter = $shelters[$index] ?? null;
            if ($shelter) {
                $shelterCreated = Shelter::factory()->create([
                    "name" => $shelter['name'],
                    "siret" => $shelter['siret'],
                    "description" => $shelter['description'],
                    "email" => $shelter['email'],
                    "phone" => $shelter['phone'],
                ]);
                $associationCreated->shelters()->attach($shelterCreated->id, ['begin_date' => now()]);
            }

            $personCreated = Person::create([
                'personable_id' => $associationCreated->id,
                'personable_type' => get_class($associationCreated)
            ]);

            $address = $addresses[$index] ?? null;
            if ($address) {
                $randomCity = City::inRandomOrder()->first();

                $addressCreated = Address::create([
                    'street1' => $address['street1'],
                    'street2' => $address['street2'] ?? null,
                    //'zipcode' => $city['zipcode'],
                    'city_id' => $randomCity->id
                ]);
                $personCreated->addresses()->attach($addressCreated);

            }
            $associationCreated->person()->save($personCreated);

            foreach (RoleEnum::cases() as $roleName) {
                $emailReadyString = Str::slug($association['name']);
                $userCreated = User::factory()->create([
                    'first_name' => ucfirst($roleName->value),
                    'last_name' => ucfirst($roleName->value),
                    'email' => $roleName->value . '-' . $emailReadyString . '@osecours.org',
                ]);
                Person::create([
                    'personable_id' => $userCreated->id,
                    'personable_type' => get_class($userCreated)
                ]);
                $roleCreated = Role::firstOrCreate(['name' => $roleName->value]);
                $associationCreated->users()->attach($userCreated->id, ['role_id' => $roleCreated->id]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Address;
use App\Models\Association;
use App\Models\City;
use App\Models\Person;
use App\Models\Role;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AssociationsSeeder extends BaseSeeder
{
    public function run(): void
    {
        $associations = json_decode(file_get_contents(database_path('data/associations.json')), true);
        $shelters = json_decode(file_get_contents(database_path('data/shelters.json')), true);
        $addresses = json_decode(file_get_contents(database_path('data/address.json')), true);
        $cities = json_decode(file_get_contents(database_path('data/cities.json')), true);

        foreach ($cities as $city) {
            City::firstOrCreate([
                'name' => $city['name'],
                'zipcode' => $city['zipcode'],
            ]);
        }

        foreach ($associations as $index => $association) {

            $associationCreated = Association::factory()->create([
                'name' => $association['name'],
                'description' => $association['description'],
                'siret' => $association['siret'],
                'rib' => $association['rib'],
            ]);

            $shelter = $shelters[$index] ?? null;
            if ($shelter) {
                $shelterCreated = Shelter::factory()->create([
                    'name' => $shelter['name'],
                    'siret' => $shelter['siret'],
                    'description' => $shelter['description'],
                    'email' => $shelter['email'],
                    'phone' => $shelter['phone'],
                ]);
                $associationCreated->shelters()->attach($shelterCreated->id, ['begin_date' => now()]);
            }

            $personCreated = Person::create([
                'personable_id' => $associationCreated->id,
                'personable_type' => get_class($associationCreated),
            ]);

            $address = $addresses[$index] ?? null;
            if ($address) {
                $randomCity = City::inRandomOrder()->first();

                $addressCreated = Address::create([
                    'street1' => $address['street1'],
                    'street2' => $address['street2'] ?? null,
                    //'zipcode' => $city['zipcode'],
                    'city_id' => $randomCity->id,
                ]);
                $personCreated->addresses()->attach($addressCreated);

            }
            $associationCreated->person()->save($personCreated);

            // Création d'utilisateurs pour jeux de tests manuels
            $faker = \Faker\Factory::create();
            $predefinedUsers = [
                'admin' => [$faker->firstName(), ucfirst('admin')],
                'user' => [$faker->firstName(), ucfirst('user')],
                'accountant' => [$faker->firstName(), ucfirst('accountant')],
                'president' => [$faker->firstName(), ucfirst('president')],
                'adopt' => [$faker->firstName(), ucfirst('adopt')],
                'other' => [$faker->firstName(), ucfirst('other')],
                'foster' => [$faker->firstName(), ucfirst('foster')],
            ];
            foreach ($predefinedUsers as $role => $names) {
                $userCreated = User::firstOrCreate(
                    ['email' => $role.'@osecours-asso.fr'],
                    [
                        'first_name' => $names[0],
                        'last_name' => $names[1],
                        'email_verified_at' => now(),
                        'password' => Hash::make('P@ssword_1'),
                        'remember_token' => Str::random(10),
                        'phone' => $this->faker->numerify('##########'),
                        'existing_cat_count' => $this->faker->numberBetween(0, 5),
                        'existing_dog_count' => $this->faker->numberBetween(0, 5),
                        'existing_children_count' => $this->faker->numberBetween(0, 5),
                    ]
                );

                Person::firstOrCreate([
                    'personable_id' => $userCreated->id,
                    'personable_type' => get_class($userCreated),
                ]);

                $roleCreated = Role::firstOrCreate(['name' => $role]);
                $associationCreated->users()->syncWithoutDetaching([$userCreated->id => ['role_id' => $roleCreated->id]]);
            }

            // Création d'utilisateurs aléatoires
            foreach (RoleEnum::cases() as $roleName) {
                $numberOfUsers = in_array($roleName->value, ['admin', 'accountant', 'president']) ? 1 : 5;

                for ($i = 0; $i < $numberOfUsers; $i++) {
                    $faker = \Faker\Factory::create();
                    $firstName = $faker->firstName();
                    $lastName = $faker->lastName() .'-'. $roleName->value;

                    $userCreated = User::factory()->create([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => strtolower($firstName).'.'.strtolower($lastName).'@osecours-asso.fr',
                    ]);
                    Person::create([
                        'personable_id' => $userCreated->id,
                        'personable_type' => get_class($userCreated),
                    ]);
                    $roleCreated = Role::firstOrCreate(['name' => $roleName->value]);
                    $associationCreated->users()->attach($userCreated->id, ['role_id' => $roleCreated->id]);
                }

            }
        }
    }
}

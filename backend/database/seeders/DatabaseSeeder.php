<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Association;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $assocationsNameList = ["Le refuge des chimères", "l'arche de noé 2.0", "quatres pattes et un toit"];


        foreach ($assocationsNameList as $associationName) {

            $associationCreated =  Association::factory()->create(["name" => $associationName]);

            foreach (RoleEnum::cases() as $roleName) {
                $emailReadyString = strtolower(Str::ascii($associationName));
                $emailReadyString = str_replace(' ', '', $emailReadyString);
                $userCreated = User::factory()->create([
                    'first_name' => ucfirst($roleName->value),
                    'last_name' => ucfirst($roleName->value),
                    'email' =>  $roleName->value . "-" . $emailReadyString . '@osecours.com',
                ]);
                $roleCreated = Role::firstOrCreate(
                    ["name" => $roleName->value]
                );
                $associationCreated->users()->attach($userCreated->id, ["role_id" => $roleCreated->id]);
            }
        }
    }
}

<?php

namespace Tests\Feature;

use App\Enum\UserStatus;
use App\Http\Services\AuthService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_with_valid_credentials()
    {

        // Récupérer un utilisateur existant ou en créer un
        $user = User::firstOrCreate([
            'email' => 'admin@osecours-asso.fr',
        ], [

            'password' => bcrypt('P@ssword_1'),
        ]);

        // Simulez une demande de connexion
        $response = $this->postJson('http://localhost:8000/api/login', [
            'email' => 'admin@osecours-asso.fr',
            'password' => 'P@ssword_1',
        ]);

        //dd($response);
        // Vérifiez que la réponse est correcte
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'status' => UserStatus::CONNECTED->value,
                'associations' => [
                    ['id' => 1, 'name' => 'Fondation Brigitte Bardot'],
                    ['id' => 31, 'name' => 'Fondation 30 Millions d\'Amis'],
                    ['id' => 61, 'name' => 'Société Protectrice des Animaux'],
                ],
            ]
        ]);
    }

//    public function test_login_with_invalid_credentials()
//    {
//        // Simulez une demande de connexion avec des identifiants invalides
//        $response = $this->postJson('http://localhost:8000/api/login', [
//            'email' => 'admin@osecours-asso.fr',
//            'password' => 'Wrong_password1',
//        ]);
//
//        // Vérifiez que la réponse est une erreur 401
//        $response->assertStatus(401);
//    }
}

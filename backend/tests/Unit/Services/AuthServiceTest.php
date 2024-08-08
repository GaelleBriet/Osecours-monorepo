<?php

namespace Tests\Unit\Services;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\AuthController;
use App\Http\Requests\AuthRequest;
use App\Http\Services\AuthService;
use App\Http\Services\ErrorService;
use App\Enum\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $authController;
    protected $errorServiceMock;
    protected $authServiceMock;
    protected $authFacade;
    protected $auth;
    protected $authService;
    protected $errorService;

    public function setUp(): void
    {
        parent::setUp();
        $this->errorService = new ErrorService();
        $this->authController = new AuthController($this->errorService);
    }

    public function test_login__user()
    {
        $email = 'admin@osecours-asso.fr';
        $password = 'P@ssword_1';
        $user = User::first('email', $email);

        $request = new AuthRequest();
        $request->setContainer(app());
        $request->setRedirector(app('redirect'));
        $request->initialize(['email' => $email, 'password' => $password]);

        $authService = new AuthService();
        $result = $authService->connectUser(['email' => $email, 'password' => $password]);
//        dump($result);
        $result['associations'] = $result['associations']->toArray();
        $this->assertEquals([
            'status' => UserStatus::CONNECTED->value,
            'associations' => [
                ['id' => 1, 'name' => 'Fondation Brigitte Bardot'],
                ['id' => 31, 'name' => 'Fondation 30 Millions d\'Amis'],
                ['id' => 61, 'name' => 'Société Protectrice des Animaux'],
            ],
        ], $result);

        $request->validateResolved();

        $response = $this->authController->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertEquals(UserStatus::CONNECTED->value, $responseData['data']['status']);
        $this->assertCount(3, $responseData['data']['associations']);
    }

    public function test_login__user_with_invalid_credentials()
    {
        $email = 'admin@osecours-asso.fr';
        $password = 'Wrong_password1';

        $request = new AuthRequest();
        $request->setContainer(app());
        $request->setRedirector(app('redirect'));
        $request->initialize(['email' => $email, 'password' => $password]);

        $authService = new AuthService();

        try {
            $authService->connectUser(['email' => $email, 'password' => $password]);
            $this->fail('Expected UnauthorizedException not thrown');
        } catch (UnauthorizedException $e) {
            $this->assertEquals('Invalid credentials', $e->getMessage());
        }

        $request->validateResolved();

        $response = $this->authController->login($request);
//        dump($response->getContent());
        // Vérifiez que la réponse est une instance de JsonResponse avec un code de statut 401
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('Invalid credentials', $responseData['error']);
    }
}

<?php

namespace Tests\Unit\Services;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\AuthController;
use App\Http\Requests\AuthRequest;
use App\Http\Services\AuthService;
use App\Http\Services\ErrorService;
use App\Enum\UserStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Mockery;

class AuthServiceTest extends TestCase
{
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
        $this->errorServiceMock = Mockery::mock(ErrorService::class);
        $this->authServiceMock = Mockery::mock('overload:' . \App\Http\Services\AuthService::class);

        $this->authController = new AuthController($this->errorServiceMock);
        $this->authService = new AuthService();
        $this->errorService = new ErrorService();
        $this->auth = Auth::class;
    }

    public function test_login__user()
    {
        $email = 'admin@osecours-asso.fr';
        $password = 'P@ssword_1';
        $user = User::first('email', $email);

        // créer manuellement une requête et la valider en dehors du service container
        // en env. de test, le laravel service container ne resoud pas les dépendances automatiquement
        // il faut donc le faire manuellement
        // le redirector n'est pas défini dans l'objet AuthRequest lors de l'éxécution des tests
        // il génère des URL pour les redirections
        $request = new AuthRequest();
        $request->setContainer(app());
        $request->setRedirector(app('redirect'));
        $request->initialize(['email' => $email, 'password' => $password]);

        // Simuler le comportement attendu de AuthService
        $this->authServiceMock->shouldReceive('connectUser')
            ->once()
            ->with(['email' => $email, 'password' => $password])
            ->andReturn([
                'status' => UserStatus::CONNECTED->value,
                'associations' => [
                    ['id' => 1, 'name' => 'Association 1'],
                    ['id' => 2, 'name' => 'Association 2'],
                ],
            ]);

        $request->validateResolved();

        $response = $this->authController->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertEquals(UserStatus::CONNECTED->value, $responseData['data']['status']);
        $this->assertCount(2, $responseData['data']['associations']);
    }

    public function test_login__user_with_invalid_credentials()
    {
        $email = 'admin@osecours-asso.fr';
        $password = 'Wrong_password1';

        $request = new AuthRequest();
        $request->setContainer(app());
        $request->setRedirector(app('redirect'));
        $request->initialize(['email' => $email, 'password' => $password]);

        // Simuler un échec de connexion
        $this->authServiceMock->shouldReceive('connectUser')
            ->once()
            ->with(['email' => $email, 'password' => $password])
            ->andThrow(UnauthorizedException::class);

        // Définir une attente pour la méthode handle() de ErrorService
        $this->errorServiceMock->shouldReceive('handle')
            ->once()
            ->with(Mockery::type(UnauthorizedException::class))
            ->andReturn(new JsonResponse(['error' => 'Unauthorized'], 401));

        $request->validateResolved();

        $response = $this->authController->login($request);

        // Vérifiez que la réponse est une instance de JsonResponse avec un code de statut 401
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('Unauthorized', $responseData['error']);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

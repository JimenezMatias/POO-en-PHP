<?php
namespace App\Controladores;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Servicios\AuthService;
use App\Exceptions\AuthenticationException;
use App\Config\Database;
use App\Modelos\UserRepository;

class AuthControlador
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    
    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        // Validaciones básicas
        if (!isset($data['nombre']) || !isset($data['password']) || !isset($data['confirmPassword'])) {
            $response->getBody()->write(json_encode(['message' => 'Datos incompletos']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $nombre = $data['nombre'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];

        if ($password !== $confirmPassword) {
            $response->getBody()->write(json_encode(['message' => 'Las contraseñas no coinciden']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            // Registrar usuario usando AuthService
            $usuario = $this->authService->registrarUsuario($nombre, $password);

            $payload = [
                'status' => 'success',
                'message' => 'Usuario registrado correctamente',
                'user' => $usuario
            ];

            $response->getBody()->write(json_encode($payload));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (\Exception $e) {
            $payload = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            $response->getBody()->write(json_encode($payload));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    
    // Login de usuario
    public function login(Request $request, Response $response): Response
    {
         try {
            $username = $request->getAttribute("user");

            $repo = new UserRepository(new Database()->getConnection());
            $user = $repo->findByNombre($username);

            // Generar token JWT
            $token = $this->authService->generarToken($user);

            // Respuesta JSON con token
            $payload = [
                'status' => 'success',
                'message' => 'Login exitoso',
                'token' => $token
            ];

        	$response->getBody()->write(json_encode($payload));

            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

        } catch (AuthenticationException $e) {
            $payload = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            $response->getBody()->write(json_encode($payload));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
     }
}

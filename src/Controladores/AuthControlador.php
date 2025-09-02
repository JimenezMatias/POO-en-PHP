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

    
    // Registro de usuario
    public function register(Request $request, Response $response): Response
    {
        // Capturar datos del formulario
        $data = $request->getParsedBody();

        $nombre = trim($data['name'] ?? '');
        $password = $data['password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';
        $idRol = 1; // rol por defecto: invitado

        // Validaciones básicas
        if (empty($nombre) || empty($password) || empty($confirmPassword)) {
            $payload = [
                'status' => 'error',
                'message' => 'Todos los campos son obligatorios'
            ];
            $response->getBody()->write(json_encode($payload));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if ($password !== $confirmPassword) {
            $payload = [
                'status' => 'error',
                'message' => 'Las contraseñas no coinciden'
            ];
            $response->getBody()->write(json_encode($payload));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            // Registrar usuario usando AuthService
            $usuario = $this->authService->registrarUsuario($nombre, $password, $idRol);

            $payload = [
                'status' => 'success',
                'message' => 'Usuario registrado correctamente',
                'user' => $usuario
            ];
            return $response
            ->withHeader("Location", "/login")
            ->withStatus(302); // 302 = redirección temporal

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

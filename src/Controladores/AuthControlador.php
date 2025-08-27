<?php

namespace App\Controladores;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Servicios\AuthServiceInterface;

class AuthControlador
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    
    // Registro de usuario
    public function register(Request $request, Response $response): Response
    {
        // 1. Capturar datos del formulario
        $data = (array)$request->getParsedBody();

        $nombre = trim($data['nombre'] ?? '');
        $password = $data['password'] ?? '';
        $confirmPassword = $data['confirmPassword'] ?? '';

        // Validaciones básicas
        if (!$nombre || !$password || !$confirmPassword) {
            $response->getBody()->write(json_encode(['error' => 'Todos los campos son obligatorios']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        if ($password !== $confirmPassword) {
            $response->getBody()->write(json_encode(['error' => 'Las contraseñas no coinciden']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            // Lógica de registro delegada a AuthService
            $usuario = $this->authService->registrarUsuario($nombre, $password);

            $response->getBody()->write(json_encode([
                'mensaje' => 'Usuario registrado correctamente',
                'usuario' => ['id' => $usuario['id_usuario'], 'nombre' => $usuario['nombre']]
            ]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
    



    
    // Login de usuario
    public function login(Request $request, Response $response): Response
    {
        // 1. Capturar datos del formulario
        $data = $request->getParsedBody();

        $nombre = $data['nombre'] ?? '';
        $password = $data['password'] ?? '';

        // 2. Verificar credenciales
        if (!$usuario) {
            $response->getBody()->write(json_encode([
                'error' => 'Credenciales invalidas'
            ]));
            return $response->withStatus(401)
                            ->withHeader('Content-Type', 'application/json');
        }


        //Generar token JWT
        $token = $this->authService->generarToken($usuario);

        $response->getBody()->write(json_encode([
            'token' => $token,
            'usuario' => [
                'id' => $usuario['id_usuario'],
                'nombre' => $usuario['nombre'],
                'rol' => $usuario['id_rol']
            ]
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function refreshToken(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $oldToken = $data['token'] ?? '';

        $claims = $this->authService->validarToken($oldToken);
        if (!$claims) {
            $response->getBody()->write(json_encode([
                'error' => 'Token inválido o expirado'
            ]));
            return $response->withStatus(401)
                            ->withHeader('Content-Type', 'application/json');
        }

        // Generar un nuevo token con los mismos datos
        $newToken = $this->authService->generarToken($claims);

        $response->getBody()->write(json_encode([
            'token' => $newToken
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}

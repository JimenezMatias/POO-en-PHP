<?php

namespace App\Controladores;


use App\Modelo\Usuario;
use App\Config\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Stream;

class AuthControlador
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        // Obtener la conexión PDO desde el Singleton Database
        $pdo = Database::getInstance()->getConnection();
        $this->usuarioModel = new Usuario($pdo);
    }

    // -----------------------------------------------------------------
    // Helper: respuesta JSON consistente
    private function jsonResponse(Response $response, array $payload, int $status = 200): Response
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $response->getBody()->write($body);
        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus($status);
    }

    // -----------------------------------------------------------------
    // Registro: POST /auth/register
    public function register(Request $request, Response $response): Response
    {
        // 1. Capturar datos del formulario
        $data = $request->getParsedBody();
        $nombre = isset($data['name']) ? trim((string)$data['name']) : '';
        $password = isset($data['password']) ? (string)$data['password'] : '';
        $confirmPassword = isset($data['confirm_password']) ? (string)$data['confirm_password'] : '';

        // 2. Validaciones mínimas
        if ($nombre === '' || $password === '' || $confirmPassword === '') {
            return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Todos los campos dfdfdfdfdfson obligatorios'], 400);
        }

        if ($password !== $confirmPassword) {
            return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Las contraseñas no coinciden'], 400);
        }

        

        

        try {
            // 3. Verificar si el nombre ya existe
            $existente = $this->usuarioModel->buscarPorNombre($nombre);
            if ($existente) {
                return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Nombre ya registrado'], 400);
            }

            // 4. Codificar password en Base64 (MVP)
            $passwordBase64 = base64_encode($password);

            // 5. Registrar usuario
            $result = $this->usuarioModel->registrar($nombre, $passwordBase64);

            if ($result === false) {
                return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'No se pudo crear el usuario'], 500);
            }

            $idCreado = is_int($result) ? $result : null;

            $emptyBody = new \Slim\Psr7\Stream(fopen('php://temp', 'r+'));
            $response = $response->withBody($emptyBody);

            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);

        } catch (\Throwable $e) {
            // Aquí podrías loguear el error en un archivo
            return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Error interno'], 500);
        }
    }



    // -----------------------------------------------------------------
    // Login: POST /auth/login
    public function login(Request $request, Response $response): Response
    {
        // 1. Capturar datos del formulario
        $data = $request->getParsedBody();
        $nombre = isset($data['name']) ? trim((string)$data['name']) : '';
        $password = isset($data['password']) ? (string)$data['password'] : '';

        // 2. Validaciones mínimas
        if ($nombre === '' || $password === '') {
            return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Nombre y password son requeridos'], 400);
        }

        try {
            // 3. Buscar usuario en la base de datos
            $user = $this->usuarioModel->buscarPorNombre($nombre);

            if (!$user) {
                return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Credenciales inválidas'], 401);
            }

            // 4. Comparar la contraseña codificada en Base64
            $passwordBase64 = base64_encode($password);

            if (!isset($user['password']) || $user['password'] !== $passwordBase64) {
                return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Credenciales inválidas'], 401);
            }

            // 5. Login exitoso: removemos password de la respuesta
            unset($user['password']);

            $emptyBody = new \Slim\Psr7\Stream(fopen('php://temp', 'r+'));
            $response = $response->withBody($emptyBody);

            return $response
            ->withHeader('Location', '/dashboard') // Cambia a la ruta que prefieras
            ->withStatus(302);
                

        } catch (\Throwable $e) {
            // Loguear internamente si es necesario
            return $this->jsonResponse($response, ['success' => false, 'mensaje' => 'Error interno'], 500);
        }
    }
}

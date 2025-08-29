<?php
namespace App\Servicios;

use App\Modelos\UserRepository;
use App\Servicios\JWTService;
use App\Servicios\PasswordHasher;
use App\Exceptions\AuthenticationException;


class AuthService 
{
    private UserRepository $userRepo;
    private JWTService $jwtService;
    private PasswordHasher $passwordHasher;
    private int $accessTtl;   // segundos

    public function __construct(
        UserRepository $userRepo,
        JWTService $jwtService,
        PasswordHasher $hasher,
        int $accessTtl = 3600,  // por defecto 1h
    ) {
        $this->userRepo  = $userRepo;
        $this->jwtService = $jwtService;
        $this->passwordHasher = $passwordHasher;
        $this->accessTtl = $accessTtl;
    }

    // Verifica las credenciales del usuario (login basico).
    public function verificarCredenciales(string $nombre, string $password): ?array
    {
        $usuario = $this->userRepo->findByNombre($nombre);

        if (!$usuario || !$this->passwordHasher->verifyPassword($password, $usuario['password'])) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        return $usuario;
    }

    // Registra un nuevo usuario en la base de datos.
    public function registrarUsuario(string $nombre, string $password, int $id_rol = 1): array
    {
        // Verificar si el usuario ya existe
        $existingUser = $this->userRepo->findByNombre($nombre);
        if ($existingUser) {
            throw new \Exception("El nombre de usuario ya está en uso");
        }

        // Hashear la contraseña
        $hashedPassword = $this->passwordHasher->hash($password);

        // Guardar el usuario en la base de datos
        $userId = $this->userRepo->create($nombre, $hashedPassword, $id_rol);

        return [
            'id_usuario' => $userId,
            'nombre' => $nombre,
            'id_rol' => $id_rol
        ];
    }

    // Genera token JWT para el usuario.
    public function generarToken(array $usuario): string
    {
        $payload = [
            'sub' => $usuario['id_usuario'],
            'nombre' => $usuario['nombre'],
            'rol' => $usuario['id_rol'],
            'iat' => time(),
            'exp' => time() + $this->accessTtl
        ];

        return $this->jwtService->encode($payload);
    }

    // Valida un token JWT y devuelve los claims si es válido
    public function validarToken(string $token): ?array
    {
        try {
            return $this->jwtService->decode($token);
        } catch (\Exception $e) {
            return null;
        }
    }

    // Obtiene los datos del usuario a partir de un token JWT válido
    public function obtenerUsuarioDesdeToken(string $token): ?array
    {
        $claims = $this->validarToken($token);
        if (!$claims || !isset($claims['sub'])) {
            return null;
        }
        return $this->userRepo->findById($claims['sub']);
    }


}

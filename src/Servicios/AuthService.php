<?php
declare(strict_types=1);

namespace App\Servicios;

use App\Modelos\User;
use App\Modelos\UserRepositoryInterface;
use App\Servicios\JWTServiceInterface;
use App\Servicios\TokenRepositoryInterface;
use App\Servicios\PasswordHasherInterface;
use App\Exceptions\AuthenticationException;


class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepo;
    private JWTServiceInterface $jwtService;
    private TokenRepositoryInterface $tokenRepo;
    private PasswordHasherInterface $hasher;
    private int $accessTtl;   // segundos
    private int $refreshTtl;  // segundos

    public function __construct(
        UserRepositoryInterface $userRepo,
        JWTServiceInterface $jwtService,
        TokenRepositoryInterface $tokenRepo,
        PasswordHasherInterface $hasher,
        int $accessTtl = 3600,        // por defecto 1h
        int $refreshTtl = 1209600     // por defecto 14 días
    ) {
        $this->userRepo  = $userRepo;
        $this->jwtService = $jwtService;
        $this->tokenRepo = $tokenRepo;
        $this->hasher = $hasher;
        $this->accessTtl = $accessTtl;
        $this->refreshTtl = $refreshTtl;
    }

    // Verifica las credenciales del usuario (login basico).
    public function verificarCredenciales(string $nombre, string $password): ?array
    {
        $usuario = $this->userRepo->findByNombre($nombre);
        if (!$usuario) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        if (!$this->hasher->verifyPassword($password, $usuario['password'])) {
            throw new AuthenticationException('Credenciales inválidas.');
        }

        return $usuario;
    }

    // Registra un nuevo usuario en la base de datos.
    public function registrarUsuario(string $nombre, string $password): array
    {
        // Verificar si el usuario ya existe
        $existingUser = $this->userRepository->findByNombre($nombre);
        if ($existingUser) {
            throw new \Exception("El nombre de usuario ya está en uso");
        }

        // Hashear la contraseña
        $hashedPassword = $this->passwordHasher->hash($password);

        // Guardar el usuario en la base de datos
        $userId = $this->userRepository->create($nombre, $hashedPassword);

        return [
            'id_usuario' => $userId,
            'nombre' => $nombre
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
        if (!$claims || !isset($claims['sub'])) return null;

        return $this->userRepo->findById($claims['sub']);
    }


    // Genera un refresh token seguro
    public function generarRefreshToken(array $usuario): string
    {
        $plain = bin2hex(random_bytes(64));
        $hash = $this->hasher->hashToken($plain);

        $this->tokenRepo->storeRefreshToken(
            (int)$usuario['id_usuario'],
            $hash,
            (new \DateTimeImmutable())->modify("+{$this->refreshTtl} seconds")
        );

        return $plain;
    }


    public function generateRefreshToken(User $user, ?string $ip = null, ?string $userAgent = null): string
    {
        $plain = bin2hex(random_bytes(64));               // token seguro
        $hash  = $this->hasher->hashToken($plain);        // hash para almacenamiento
        $expiresAt = (new DateTimeImmutable())->modify("+{$this->refreshTtl} seconds");

        // Persistir (implementación en TokenRepository)
        $this->tokenRepo->storeRefreshToken((int)$user->getId(), $hash, $expiresAt, $ip, $userAgent);

        return $plain;
    }

    // Valida un refresh token y devuelve el usuario asociado
    public function validarRefreshToken(string $refreshToken): ?array
    {
        $registro = $this->tokenRepo->findByTokenHash($refreshToken);
        if (!$registro) return null;

        return $this->userRepo->findById($registro['user_id']);
    }
}

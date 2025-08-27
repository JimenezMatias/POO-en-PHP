<?php
namespace App\Servicios;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTService implements JWTServiceInterface
{
    private string $secret;
    private string $algo;

    public function __construct(string $secret, string $algo = 'HS256')
    {
        $this->secret = $secret;
        $this->algo = $algo;
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->secret, $this->algo);
    }

    public function decode(string $jwt): array
    {
        try {
            $decoded = JWT::decode($jwt, new Key($this->secret, $this->algo));
            return (array)$decoded; // convertir a array asociativo
        } catch (Exception $e) {
            throw new Exception('Token inválido o expirado');
        }
    }
}
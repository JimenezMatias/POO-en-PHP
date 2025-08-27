<?php
namespace App\Servicios;

class PasswordHasher implements PasswordHasherInterface
{
    public function hashPassword(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }

    public function hashToken(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    public function verifyToken(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }
}

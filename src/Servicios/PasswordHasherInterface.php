<?php

namespace App\Servicios;

interface PasswordHasherInterface
{
    public function hashPassword(string $plain): string;
    public function verifyPassword(string $plain, string $hash): bool;

    public function hashToken(string $plain): string;
    public function verifyToken(string $plain, string $hash): bool;
}
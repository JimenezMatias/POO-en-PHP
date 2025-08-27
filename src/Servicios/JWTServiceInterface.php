<?php
namespace App\Servicios;

interface JWTServiceInterface
{
    public function encode(array $payload): string;
    public function decode(string $jwt): array; // lanza excepción si inválido
}
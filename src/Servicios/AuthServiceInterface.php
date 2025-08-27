<?php
namespace App\Servicios; 

interface AuthServiceInterface
{
    // Verifica las credenciales del usuario
    public function verificarCredenciales(string $nombre, string $password): ?array;

    // Genera un token JWT para el usuario
    public function generarToken(array $usuario): string;

    // Validar un token JWT y devuelve los claims si es válido
    public function validarToken(string $token): ?array;

    // Obtiene los datos del usuario a partir de un token JWT válido
    public function obtenerUsuarioDesdeToken(string $token): ?array;

    // Genera un refresh token seguro
    public function generarRefreshToken(array $usuario): string;

    // Valida un refresh token y devuelve el usuario asociado
    public function validarRefreshToken(string $refreshToken): ?array;
}

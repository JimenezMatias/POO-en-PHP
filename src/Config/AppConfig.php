<?php
namespace App\Config;

use App\Modelos\UserRepository;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Servicios\PasswordHasher;

class AppConfig
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getPDO(): \PDO
    {
        return $this->database->getConnection();
    }

    public function getJWTService(): JWTService
    {
        $secret = $_ENV['JWT_SECRET'];
        $algo = $_ENV['JWT_ALGO'] ?? 'HS256';
        return new JWTService($secret, $algo);
    }

    public function getPasswordHasher(): PasswordHasher
    {
        return new PasswordHasher();
    }

    public function getUserRepository(): UserRepository
    {
        return new UserRepository($this->getPDO());
    }

    public function getAuthService(): AuthService
    {
        return new AuthService(
            $this->getUserRepository(),
            $this->getJWTService(),
            $this->getPasswordHasher()
        );
    }
}

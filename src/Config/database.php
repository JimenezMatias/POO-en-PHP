<?php
namespace App\Config;
use PDO;
use Dotenv\Dotenv;

class Database {
    
    private PDO $pdo;
    
    private function __construct() {

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $host = $_ENV['127.0.0.1'];
        $dbname = $_ENV['PuntoDeVenta'];
        $user = $_ENV['root'];
        $pass = $_ENV['root'];
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}



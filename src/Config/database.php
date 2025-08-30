<?php
namespace App\Config;
use PDO;
use Dotenv\Dotenv;

class Database {
    
    private PDO $pdo;
    
    public function __construct() {

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
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



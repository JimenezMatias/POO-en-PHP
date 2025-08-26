<?php
namespace App\Config;
use PDO;
use PDOException;

//Clase utilizando patron de diseño Singleton.
class Database {
    private static ?Database $instance = null;
    private PDO $connection;
    

    // Propiedades privadas de configuración
    private string $host    = '127.0.0.1';
    private string $db      = 'PuntoDeVenta';
    private string $user    = 'root';
    private string $pass    = 'root';
    private int    $port    = 3306;
    private string $charset = 'utf8mb4';

    private function __construct() {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT         => true,
        ];

        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // Lanzamos una excepción más genérica para que pueda ser capturada externamente
            throw new RuntimeException("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}



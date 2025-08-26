<?php

namespace App\Modelo;

use PDO;
use PDOException;

class Usuario
{
    private PDO $conn;

    public function __construct(PDO $pdo)
    {
        $this->conn = $pdo;
    }

    // -----------------------------------------------------------------
    // Buscar un usuario por su nombre
    public function buscarPorNombre(string $nombre): ?array
    {
        $sql = "SELECT id_usuario, nombre, password FROM usuarios WHERE nombre = :nombre LIMIT 1";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            return $usuario ?: null;
        } catch (PDOException $e) {
            // Loguear error si es necesario
            return null;
        }
    }

    // -----------------------------------------------------------------
    // Registrar un nuevo usuario
    public function registrar(string $nombre, string $passwordBase64)
    {
        $sql = "INSERT INTO usuarios (nombre, password) VALUES (:nombre, :password)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordBase64, PDO::PARAM_STR);

            $stmt->execute();

            // Retornar el id del usuario insertado
            return (int)$this->conn->lastInsertId();
        } catch (PDOException $e) {
            // Loguear error si es necesario
            return false;
        }
    }
}

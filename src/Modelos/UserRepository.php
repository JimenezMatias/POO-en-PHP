<?php

namespace App\Modelos;

use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByNombre(string $nombre): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE nombre = :nombre LIMIT 1");
        $stmt->execute(['nombre' => $nombre]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(string $nombre, string $password): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, password) VALUES (:nombre, :password)");
        $stmt->execute(['nombre' => $nombre, 'password' => $password]);
        return (int)$this->pdo->lastInsertId();
    }
}
<?php
namespace App\Modelos;

use PDO;

class ProvinciasRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Listar todas las provincias
    public function listar(): array {
        $stmt = $this->pdo->query("SELECT id_provincia, provincia FROM provincias ORDER BY provincia");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Opcional: obtener por id
    public function obtenerPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT id_provincia, provincia FROM provincias WHERE id_provincia = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

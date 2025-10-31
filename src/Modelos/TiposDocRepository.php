<?php
namespace App\Modelos;

use PDO;

class TiposDocRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("
            SELECT id_tipo_doc, descrip_tipo_doc 
            FROM tipos_doc 
            ORDER BY descrip_tipo_doc
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT id_tipo_doc, descrip_tipo_doc 
            FROM tipos_doc 
            WHERE id_tipo_doc = :id
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}


<?php
namespace App\Modelos;

use PDO;

class TiposDocAfipRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("
            SELECT id_tipo_doc_afip, descrip_tipo_doc_afip 
            FROM tipos_doc_afip 
            ORDER BY descrip_tipo_doc_afip
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT id_tipo_doc_afip, descrip_tipo_doc_afip 
            FROM tipos_doc_afip 
            WHERE id_tipo_doc_afip = :id
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}


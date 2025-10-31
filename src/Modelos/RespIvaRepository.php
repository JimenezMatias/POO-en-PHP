<?php
namespace App\Modelos;

use PDO;

class RespIvaRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("
            SELECT id_resp_iva, descrip_resp_iva 
            FROM resp_iva 
            ORDER BY descrip_resp_iva
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT id_resp_iva, descrip_resp_iva 
            FROM resp_iva 
            WHERE id_resp_iva = :id
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}


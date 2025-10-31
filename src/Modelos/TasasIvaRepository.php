<?php
namespace App\Modelos;

use PDO;

class TasasIvaRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Listar todas las tasas de IVA
    public function listar(): array {
        $stmt = $this->pdo->query("SELECT id_tasa_iva, descrip_tasa_iva FROM tasas_iva ORDER BY descrip_tasa_iva");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una tasa por id
    public function obtenerPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT id_tasa_iva, valor FROM tasas_iva WHERE id_tasa_iva = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

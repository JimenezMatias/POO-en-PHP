<?php
namespace App\Modelos;

use PDO;

class UnidadesMedidasRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT codigo_uni_medida, descripcion_uni_medida FROM unidades_medidas ORDER BY descripcion_uni_medida");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCodigo(string $codigo): ?array {
        $stmt = $this->pdo->prepare("SELECT codigo_uni_medida, nombre FROM unidades_medidas WHERE codigo_uni_medida = :codigo");
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

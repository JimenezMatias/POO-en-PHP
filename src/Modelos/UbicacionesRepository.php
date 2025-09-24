<?php
namespace App\Modelos;

use PDO;

class UbicacionesRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM ubicaciones");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO ubicaciones (desc_ubicacion) VALUES (:desc_ubicacion)"
        );
        return $stmt->execute($data);
    }

    public function editar(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE ubicaciones SET
                desc_ubicacion = :desc_ubicacion
             WHERE id_ubicacion = :id"
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM ubicaciones WHERE id_ubicacion = :id");
        return $stmt->execute(['id' => $id]);
    }
}
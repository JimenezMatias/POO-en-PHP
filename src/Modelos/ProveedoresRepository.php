<?php
namespace App\Modelos;

use PDO;

class ProveedoresRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM proveedores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO proveedores 
            (razon_social, domicilio, telefono, mail, celular, obsv) 
            VALUES (:razon_social, :domicilio, :telefono, :mail, :celular, :obsv)"
        );
        return $stmt->execute($data);
    }

    public function editar(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE proveedores SET
                razon_social = :razon_social,
                domicilio = :domicilio,
                telefono = :telefono,
                mail = :mail,
                celular = :celular,
                obsv = :obsv
             WHERE id_proveedor = :id"
        );
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM proveedores WHERE id_proveedor = :id");
        return $stmt->execute(['id' => $id]);
    }
}

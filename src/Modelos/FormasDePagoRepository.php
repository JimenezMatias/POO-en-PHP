<?php
namespace App\Modelos;

use PDO;

class FormasDePagoRepository 
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM formaDePagos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $data): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO formaDePagos (nombre) VALUES (:nombre)");
        $stmt->execute([
            'nombre' => $data['nombre']
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function editar(int $id, string $nombre): bool
    {
        $stmt = $this->pdo->prepare("UPDATE formaDePagos SET nombre = :nombre WHERE id_formaDePago = :id");
        return $stmt->execute([
            'id' => $id,
            'nombre' => $nombre
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM formaDePagos WHERE id_formaDePago = :id");
        return $stmt->execute(['id' => $id]);
    }
}


?>
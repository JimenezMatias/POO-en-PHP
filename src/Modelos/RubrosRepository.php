<?php
namespace App\Modelos;

use PDO;

class RubrosRepository 
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM rubros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $data): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO rubros (desc_rubro) VALUES (:desc_rubro)");
        $stmt->execute([
            'desc_rubro' => $data['desc_rubro']
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function editar(int $id, string $desc_rubro): bool
    {
        $stmt = $this->pdo->prepare("UPDATE rubros SET desc_rubro = :desc_rubro WHERE id_rubro = :id");
        return $stmt->execute([
            'id' => $id,
            'desc_rubro' => $desc_rubro
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM rubros WHERE id_rubro = :id");
        return $stmt->execute(['id' => $id]);
    }
}


?>
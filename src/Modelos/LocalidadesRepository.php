<?php
namespace App\Modelos;

use PDO;

class LocalidadesRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Listar todas las localidades con su provincia
    public function listar(): array {
        $sql = "SELECT l.cp, l.localidad, l.id_provincia, p.provincia 
                FROM localidades l
                INNER JOIN provincias p ON l.id_provincia = p.id_provincia";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nueva localidad
    public function crear(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO localidades (cp, localidad, id_provincia) 
             VALUES (:cp, :localidad, :id_provincia)"
        );
        return $stmt->execute([
            'cp' => $data['cp'],
            'localidad' => $data['localidad'],
            'id_provincia' => $data['id_provincia']
        ]);
    }

    // Editar localidad
    public function editar(int $cp, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE localidades 
             SET localidad = :localidad, id_provincia = :id_provincia 
             WHERE cp = :cp"
        );
        return $stmt->execute([
            'cp' => $cp,
            'localidad' => $data['localidad'],
            'id_provincia' => $data['id_provincia']
        ]);
    }

    // Eliminar localidad
    public function eliminar(int $cp): bool {
        $stmt = $this->pdo->prepare("DELETE FROM localidades WHERE cp = :cp");
        return $stmt->execute(['cp' => $cp]);
    }

    // (Opcional) Obtener una localidad por su CP
    public function obtenerPorCp(int $cp): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM localidades WHERE cp = :cp");
        $stmt->execute(['cp' => $cp]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

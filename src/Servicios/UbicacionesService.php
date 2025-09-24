<?php
namespace App\Servicios;

use App\Modelos\UbicacionesRepository;
use InvalidArgumentException;

class UbicacionesService {
    private UbicacionesRepository $repository;

    public function __construct(UbicacionesRepository $repository) {
        $this->repository = $repository;
    }

    public function listar(): array {
        return $this->repository->listar();
    }

    public function crear(array $data): bool {
        if (trim($data['desc_ubicacion']) === '') {
            throw new InvalidArgumentException("La ubicacion es obligatoria");
        }
        
        return $this->repository->crear($data);
    }

    public function editar(int $id, array $data): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido");
        }
        return $this->repository->editar($id, $data);
    }

    public function eliminar(int $id): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido");
        }
        return $this->repository->eliminar($id);
    }
}
?>
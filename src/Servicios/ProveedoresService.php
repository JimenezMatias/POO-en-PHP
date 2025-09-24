<?php
namespace App\Servicios;

use App\Modelos\ProveedoresRepository;
use InvalidArgumentException;

class ProveedoresService {
    private ProveedoresRepository $repository;

    public function __construct(ProveedoresRepository $repository) {
        $this->repository = $repository;
    }

    public function listar(): array {
        return $this->repository->listar();
    }

    public function crear(array $data): bool {
        if (trim($data['razon_social']) === '') {
            throw new InvalidArgumentException("La razón social es obligatoria");
        }
        // Podés agregar más validaciones para email, teléfono, etc.
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
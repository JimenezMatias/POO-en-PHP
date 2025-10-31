<?php
namespace App\Servicios;

use App\Modelos\ClientesRepository;
use InvalidArgumentException;

class ClientesService {
    private ClientesRepository $repository;

    public function __construct(ClientesRepository $repository) {
        $this->repository = $repository;
    }

    public function listar(): array {
        return $this->repository->listar();
    }

    public function obtenerPorId(int $id): ?array {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido");
        }
        return $this->repository->obtenerPorId($id);
    }

    public function crear(array $data): bool {
        // Validaciones
        if (empty(trim($data['razon_social'] ?? ''))) {
            throw new InvalidArgumentException("La razón social es obligatoria");
        }
        
        if (empty($data['id_resp_iva'])) {
            throw new InvalidArgumentException("La responsabilidad de IVA es obligatoria");
        }

        // Valores por defecto
        $data['limite_cc'] = $data['limite_cc'] ?? 0;
        
        return $this->repository->crear($data);
    }

    public function editar(int $id, array $data): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido");
        }
        
        if (empty(trim($data['razon_social'] ?? ''))) {
            throw new InvalidArgumentException("La razón social es obligatoria");
        }
        
        return $this->repository->editar($id, $data);
    }

    public function eliminar(int $id): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException("ID inválido");
        }
        
        // No permitir eliminar el cliente "Consumidor Final" (id = 1)
        if ($id === 1) {
            throw new InvalidArgumentException("No se puede eliminar el cliente 'Consumidor Final'");
        }
        
        return $this->repository->eliminar($id);
    }
}


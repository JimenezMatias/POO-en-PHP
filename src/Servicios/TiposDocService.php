<?php
namespace App\Servicios;

use App\Modelos\TiposDocRepository;

class TiposDocService {
    private TiposDocRepository $repository;

    public function __construct(TiposDocRepository $repository) {
        $this->repository = $repository;
    }

    public function listar(): array {
        return $this->repository->listar();
    }

    public function obtenerPorId(int $id): ?array {
        return $this->repository->obtenerPorId($id);
    }
}


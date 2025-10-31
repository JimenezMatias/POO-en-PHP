<?php
namespace App\Servicios;

use App\Modelos\TiposDocAfipRepository;

class TiposDocAfipService {
    private TiposDocAfipRepository $repository;

    public function __construct(TiposDocAfipRepository $repository) {
        $this->repository = $repository;
    }

    public function listar(): array {
        return $this->repository->listar();
    }

    public function obtenerPorId(int $id): ?array {
        return $this->repository->obtenerPorId($id);
    }
}


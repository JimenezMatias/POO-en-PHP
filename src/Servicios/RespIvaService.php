<?php
namespace App\Servicios;

use App\Modelos\RespIvaRepository;

class RespIvaService {
    private RespIvaRepository $repository;

    public function __construct(RespIvaRepository $repository) {
        $this->repository = $repository;
    }

    public function listar(): array {
        return $this->repository->listar();
    }

    public function obtenerPorId(int $id): ?array {
        return $this->repository->obtenerPorId($id);
    }
}


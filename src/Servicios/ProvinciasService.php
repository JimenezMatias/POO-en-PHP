<?php
namespace App\Servicios;

use App\Modelos\ProvinciasRepository;

class ProvinciasService {
    private ProvinciasRepository $provinciasRepository;

    public function __construct(ProvinciasRepository $provinciasRepository) {
        $this->provinciasRepository = $provinciasRepository;
    }

    public function listar(): array {
        return $this->provinciasRepository->listar();
    }

    public function obtenerPorId(int $id): ?array {
        return $this->provinciasRepository->obtenerPorId($id);
    }
}

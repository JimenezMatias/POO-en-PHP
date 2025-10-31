<?php
namespace App\Servicios;

use App\Modelos\TasasIvaRepository;

class TasasIvaService {
    private TasasIvaRepository $tasasIvaRepository;

    public function __construct(TasasIvaRepository $tasasIvaRepository) {
        $this->tasasIvaRepository = $tasasIvaRepository;
    }

    public function listar(): array {
        return $this->tasasIvaRepository->listar();
    }

    public function obtenerPorId(int $id): ?array {
        return $this->tasasIvaRepository->obtenerPorId($id);
    }
}

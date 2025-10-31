<?php
namespace App\Servicios;

use App\Modelos\UnidadesMedidasRepository;

class UnidadesMedidasService {
    private UnidadesMedidasRepository $unidadesMedidasRepository;

    public function __construct(UnidadesMedidasRepository $unidadesMedidasRepository) {
        $this->unidadesMedidasRepository = $unidadesMedidasRepository;
    }

    public function listar(): array {
        return $this->unidadesMedidasRepository->listar();
    }

    public function obtenerPorCodigo(string $codigo): ?array {
        return $this->unidadesMedidasRepository->obtenerPorCodigo($codigo);
    }
}

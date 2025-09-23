<?php
namespace App\Servicios;

use App\Modelos\LocalidadesRepository;

class LocalidadesService {
    private LocalidadesRepository $LocalidadesRepository;

    public function __construct(LocalidadesRepository $LocalidadesRepository) {
        $this->LocalidadesRepository = $LocalidadesRepository;
    }

    public function listar(): array {
        return $this->LocalidadesRepository->listar();
    }

    public function crear(int $cp, string $localidad, int $id_provincia): bool {
        if ($cp <= 0) {
            throw new \InvalidArgumentException("El código postal es obligatorio y debe ser un entero positivo.");
        }
        if (trim($localidad) === '') {
            throw new \InvalidArgumentException("La localidad es obligatoria y debe ser una cadena no vacía.");
        }
        if ($id_provincia <= 0) {
            throw new \InvalidArgumentException("El ID de provincia es obligatorio y debe ser un entero positivo.");
        }
        
        $data = [
            'cp' => $cp,
            'localidad' => $localidad,
            'id_provincia' => $id_provincia
        ];

        return $this->LocalidadesRepository->crear($data);
    }

    public function editar(int $cp, array $data): bool {
        return $this->LocalidadesRepository->editar($cp, $data);
    }

    public function eliminar(int $cp): bool {
        return $this->LocalidadesRepository->eliminar($cp);
    }

    public function obtenerPorCp(int $cp): ?array {
        return $this->LocalidadesRepository->obtenerPorCp($cp);
    }
}

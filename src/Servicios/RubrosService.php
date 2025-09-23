<?php
namespace App\Servicios;

use App\Modelos\RubrosRepository;

class RubrosService 
{
    private RubrosRepository $RubrosRepository;

    public function __construct(
        RubrosRepository $RubrosRepository
    ) {
        $this->RubrosRepository  = $RubrosRepository;
    }

    // Métodos
    public function listarRubro(): array
    {
        return $this->RubrosRepository->listar();
    }

    public function crearRubro(string $nombre): int
    {
        // Validación básica
        if (empty($nombre)) {
            throw new \InvalidArgumentException("El rubro es obligatorio");
        }

        $data = [
            'desc_rubro' => $nombre
        ];

        return $this->RubrosRepository->crear($data);
    }


    public function editarRubro(int $id, array $data): bool
    {
        if (empty($data['desc_rubro'])) {
            return ["error" => "El rubro es obligatorio"];
        }

        return $this->RubrosRepository->editar($id, $data['desc_rubro']);
    }

    public function eliminarRubro(int $id): bool
    {
        return $this->RubrosRepository->eliminar($id);
    }

}

?>
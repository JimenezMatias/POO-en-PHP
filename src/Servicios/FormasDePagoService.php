<?php
namespace App\Servicios;

use App\Modelos\FormasDePagoRepository;

class FormasDePagoService 
{
    private FormasDePagoRepository $FormasDePagoRepository;

    public function __construct(
        FormasDePagoRepository $FormasDePagoRepository
    ) {
        $this->FormasDePagoRepository  = $FormasDePagoRepository;
    }

    // Métodos
    public function listarFormasDePago(): array
    {
        return $this->FormasDePagoRepository->listar();
    }

    public function crearFormaDePago(string $nombre): int
    {
        // Validación básica
        if (empty($nombre)) {
            throw new \InvalidArgumentException("El nombre es obligatorio");
        }

        $data = [
            'nombre' => $nombre
        ];

        return $this->FormasDePagoRepository->crear($data);
    }


    public function editarFormaDePago(int $id, array $data): bool
    {
        if (empty($data['nombre'])) {
            return ["error" => "El nombre es obligatorio"];
        }

        return $this->FormasDePagoRepository->editar($id, $data['nombre']);
    }

    public function eliminarFormaDePago(int $id): bool
    {
        return $this->FormasDePagoRepository->eliminar($id);
    }

}

?>
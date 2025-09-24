<?php
namespace App\Servicios;

use App\Modelos\ArticulosRepository;
use InvalidArgumentException;

class ArticulosService {
    private ArticulosRepository $repository;

    public function __construct(ArticulosRepository $repository) {
        $this->repository = $repository;
    }

    // Listar todos los productos
    public function listar(): array {
        return $this->repository->listar();
    }

    // Crear un producto con validaciones mínimas
    public function crear(array $data): bool {
        if (trim($data['detalle']) === '') {
            throw new InvalidArgumentException("El nombre del producto es obligatorio");
        }
        if (!isset($data['precio_venta']) || $data['precio_venta'] <= 0) {
            throw new InvalidArgumentException("El precio de venta debe ser mayor a 0");
        }
        // Podés agregar más validaciones según negocio (stock, proveedor, rubro, etc.)
        return $this->repository->crear($data);
    }

    // Editar un producto
    public function editar(string $codigo, array $data): bool {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("El código del producto es obligatorio");
        }
        return $this->repository->editar($codigo, $data);
    }

    // Eliminar un producto
    public function eliminar(string $codigo): bool {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("El código del producto es obligatorio");
        }
        return $this->repository->eliminar($codigo);
    }
}
?>

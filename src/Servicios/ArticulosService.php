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

    // Obtener un producto por código
    public function obtenerPorCodigo(string $codigo): array {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("El código del producto es obligatorio");
        }
        
        $producto = $this->repository->obtenerPorCodigo($codigo);
        
        if (!$producto) {
            throw new InvalidArgumentException("Producto no encontrado");
        }
        
        return $producto;
    }

    // Sumar stock (permite positivos y negativos)
    public function sumarStock(string $codigo, float $cantidad): array {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("El código del producto es obligatorio");
        }
        
        if ($cantidad == 0) {
            throw new InvalidArgumentException("La cantidad no puede ser 0");
        }
        
        // Verificar que el producto existe
        $producto = $this->repository->obtenerPorCodigo($codigo);
        if (!$producto) {
            throw new InvalidArgumentException("Producto no encontrado");
        }
        
        // Actualizar stock
        $resultado = $this->repository->sumarStock($codigo, $cantidad);
        
        if (!$resultado) {
            throw new InvalidArgumentException("Error al actualizar el stock");
        }
        
        // Devolver producto actualizado
        return $this->repository->obtenerPorCodigo($codigo);
    }

    // Actualizar precio de venta
    public function actualizarPrecio(string $codigo, float $precio): array {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("El código del producto es obligatorio");
        }
        
        if ($precio <= 0) {
            throw new InvalidArgumentException("El precio debe ser mayor a 0");
        }
        
        // Verificar que el producto existe
        $producto = $this->repository->obtenerPorCodigo($codigo);
        if (!$producto) {
            throw new InvalidArgumentException("Producto no encontrado");
        }
        
        // Actualizar precio
        $resultado = $this->repository->actualizarPrecio($codigo, $precio);
        
        if (!$resultado) {
            throw new InvalidArgumentException("Error al actualizar el precio");
        }
        
        // Devolver producto actualizado
        return $this->repository->obtenerPorCodigo($codigo);
    }
}
?>

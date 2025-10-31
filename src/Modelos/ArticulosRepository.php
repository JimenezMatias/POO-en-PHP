<?php
namespace App\Modelos;

use PDO;

class ArticulosRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Listar todos los productos
    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM productos");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }

    // Crear un nuevo producto
    public function crear(array $data): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO productos
            (codigo, detalle, costo, porcen, precio_venta, stock, id_ubicacion, id_proveedor, id_rubro, codigo_uni_medida, id_tasa_iva, punto_pedido, bonif, obsv)
            VALUES
            (:codigo, :detalle, :costo, :porcen, :precio_venta, :stock, :id_ubicacion, :id_proveedor, :id_rubro, :codigo_uni_medida, :id_tasa_iva, :punto_pedido, :bonif, :obsv)
        ");
        return $stmt->execute($data);
    }

    // Editar un producto por código
    public function editar(string $codigo, array $data): bool {
        $stmt = $this->pdo->prepare("
            UPDATE productos SET
                detalle = :detalle,
                costo = :costo,
                porcen = :porcen,
                precio_venta = :precio_venta,
                stock = :stock,
                id_ubicacion = :id_ubicacion,
                id_proveedor = :id_proveedor,
                id_rubro = :id_rubro,
                codigo_uni_medida = :codigo_uni_medida,
                id_tasa_iva = :id_tasa_iva,
                punto_pedido = :punto_pedido,
                bonif = :bonif,
                obsv = :obsv
            WHERE codigo = :codigo
        ");
        $data['codigo'] = $codigo;
        return $stmt->execute($data);
    }

    // Eliminar un producto por código
    public function eliminar(string $codigo): bool {
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE codigo = :codigo");
        return $stmt->execute(['codigo' => $codigo]);
    }

    // Obtener un producto por código (para Stock)
    public function obtenerPorCodigo(string $codigo): ?array {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.codigo,
                p.detalle,
                p.stock,
                p.precio_venta,
                p.costo,
                p.porcen,
                p.id_ubicacion,
                p.id_proveedor,
                p.id_rubro,
                p.codigo_uni_medida,
                p.id_tasa_iva,
                p.punto_pedido,
                p.bonif,
                p.obsv
            FROM productos p
            WHERE p.codigo = :codigo
        ");
        $stmt->execute(['codigo' => $codigo]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // Sumar stock (permite positivos y negativos)
    public function sumarStock(string $codigo, float $cantidad): bool {
        $stmt = $this->pdo->prepare("
            UPDATE productos 
            SET stock = stock + :cantidad 
            WHERE codigo = :codigo
        ");
        return $stmt->execute([
            'codigo' => $codigo,
            'cantidad' => $cantidad
        ]);
    }

    // Actualizar precio de venta
    public function actualizarPrecio(string $codigo, float $precio): bool {
        $stmt = $this->pdo->prepare("
            UPDATE productos 
            SET precio_venta = :precio 
            WHERE codigo = :codigo
        ");
        return $stmt->execute([
            'codigo' => $codigo,
            'precio' => $precio
        ]);
    }
}

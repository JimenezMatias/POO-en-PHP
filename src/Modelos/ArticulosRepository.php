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
}

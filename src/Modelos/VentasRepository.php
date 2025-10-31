<?php
namespace App\Modelos;

use PDO;
use PDOException;

class VentasRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function generarVenta($idUsuario, $idCliente, $idTipoVenta) {
        try {
            $stmt = $this->pdo->prepare("CALL spu_generarVenta(:idUsuario, :idCliente, :idTipoVenta)");
            $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':idTipoVenta', $idTipoVenta, PDO::PARAM_INT);
            $stmt->execute();

            
            // Asumimos que el SPU devuelve un result set con los datos de la venta
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result : [];
        } catch (PDOException $e) {
            throw new \Exception("Error al ejecutar spu_generarVenta: " . $e->getMessage());
        }
    }

    public function actualizarCabecera(int $idVenta, ?int $idCliente, ?int $idTipoVenta): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_actualizarCabeceraVenta(:idVenta, :idCliente, :idTipoVenta)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
            $stmt->bindParam(':idTipoVenta', $idTipoVenta, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : [];
        } catch (PDOException $e) {
            throw new \Exception("Error al actualizar cabecera: " . $e->getMessage());
        }
    }

    public function agregarProducto(int $idVenta, string $codigo, float $cantidad): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_agregarProductoDetalle(:idVenta, :codigo, :cantidad)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
            $stmt->execute();

            // El SPU devuelve el detalle completo + totales
            $detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $detalle;
        } catch (PDOException $e) {
            throw new \Exception("Error al agregar producto: " . $e->getMessage());
        }
    }

    public function eliminarProducto(int $idVenta, string $codigo): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_eliminarProductoDetalle(:idVenta, :codigo)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();

            // El SPU devuelve el detalle actualizado
            $detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $detalle;
        } catch (PDOException $e) {
            throw new \Exception("Error al eliminar producto: " . $e->getMessage());
        }
    }

    public function obtenerDetalle(int $idVenta): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_obtenerDetalleVenta(:idVenta)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Error al obtener detalle: " . $e->getMessage());
        }
    }

    public function obtenerTotales(int $idVenta): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_obtenerTotalesVenta(:idVenta)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : [];
        } catch (PDOException $e) {
            throw new \Exception("Error al obtener totales: " . $e->getMessage());
        }
    }

    public function finalizarVenta(int $idVenta): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_finalizarVenta(:idVenta)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : [];
        } catch (PDOException $e) {
            throw new \Exception("Error al finalizar venta: " . $e->getMessage());
        }
    }

    public function cancelarVenta(int $idVenta): array {
        try {
            $stmt = $this->pdo->prepare("CALL spu_cancelarVenta(:idVenta)");
            $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : [];
        } catch (PDOException $e) {
            throw new \Exception("Error al cancelar venta: " . $e->getMessage());
        }
    }
}

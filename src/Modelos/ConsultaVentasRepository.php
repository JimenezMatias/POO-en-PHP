<?php
namespace App\Modelos;

use PDO;

class ConsultaVentasRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Consultar ventas por rango de fechas usando SPU
     */
    public function consultarVentas(string $fechaDesde, string $fechaHasta): array {
        $stmt = $this->pdo->prepare("CALL spu_ventas_fecha(?, ?)");
        $stmt->execute([$fechaDesde, $fechaHasta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Consultar todas las ventas
     */
    public function consultarTodasVentas(): array {
        $stmt = $this->pdo->prepare("CALL spu_ventas_todas()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Consultar ventas de hoy usando SPU
     */
    public function consultarVentasHoy(string $fechaHoy): array {
        $stmt = $this->pdo->prepare("CALL spu_ventas_hoy(?)");
        $stmt->execute([$fechaHoy]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener detalle de una venta usando SPU
     */
    public function obtenerDetalleVenta(int $idVenta): array {
        $stmt = $this->pdo->prepare("CALL spu_detalle_venta(?)");
        $stmt->execute([$idVenta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen por forma de pago por fechas usando SPU existente
     */
    public function resumenFormasPago(string $fechaDesde, string $fechaHasta): array {
        $stmt = $this->pdo->prepare("CALL spu_ventas_fp_fecha(?, ?)");
        $stmt->execute([$fechaDesde, $fechaHasta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen todas las formas de pago usando SPU existente
     */
    public function resumenTodasFormasPago(): array {
        $stmt = $this->pdo->prepare("CALL spu_ventas_fp_todas()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen formas de pago de hoy usando SPU existente
     */
    public function resumenFormasPagoHoy(string $fechaHoy): array {
        $stmt = $this->pdo->prepare("CALL spu_ventas_fp_hoy(?)");
        $stmt->execute([$fechaHoy]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

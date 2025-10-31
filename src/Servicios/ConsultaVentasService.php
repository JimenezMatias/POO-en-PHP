<?php
namespace App\Servicios;

use App\Modelos\ConsultaVentasRepository;
use InvalidArgumentException;

class ConsultaVentasService {
    private ConsultaVentasRepository $repository;

    public function __construct(ConsultaVentasRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Consultar ventas por rango de fechas
     */
    public function consultarVentas(string $fechaDesde = '', string $fechaHasta = ''): array {
        // Si ambas fechas están vacías, consultar todas las ventas
        if (empty($fechaDesde) && empty($fechaHasta)) {
            return $this->repository->consultarTodasVentas();
        }

        // Validar fechas si se proporcionan
        if (!empty($fechaDesde) && !$this->validarFecha($fechaDesde)) {
            throw new InvalidArgumentException("Formato de fecha 'desde' inválido. Use YYYY-MM-DD");
        }

        if (!empty($fechaHasta) && !$this->validarFecha($fechaHasta)) {
            throw new InvalidArgumentException("Formato de fecha 'hasta' inválido. Use YYYY-MM-DD");
        }

        // Si solo falta una fecha, usar valores por defecto
        if (empty($fechaDesde)) {
            $fechaDesde = '2000-01-01'; // Fecha muy antigua
        }
        if (empty($fechaHasta)) {
            $fechaHasta = date('Y-m-d'); // Fecha de hoy
        }

        if ($fechaDesde > $fechaHasta) {
            throw new InvalidArgumentException("La fecha desde no puede ser mayor a la fecha hasta");
        }

        return $this->repository->consultarVentas($fechaDesde, $fechaHasta);
    }

    /**
     * Consultar todas las ventas
     */
    public function consultarTodasVentas(): array {
        return $this->repository->consultarTodasVentas();
    }

    /**
     * Consultar ventas de hoy
     */
    public function consultarVentasHoy(string $fechaHoy = ''): array {
        // Si no se proporciona fecha, usar la fecha de hoy
        if (empty($fechaHoy)) {
            $fechaHoy = date('Y-m-d');
        }

        if (!$this->validarFecha($fechaHoy)) {
            throw new InvalidArgumentException("Formato de fecha inválido. Use YYYY-MM-DD");
        }

        return $this->repository->consultarVentasHoy($fechaHoy);
    }

    /**
     * Obtener detalle de una venta
     */
    public function obtenerDetalleVenta(int $idVenta): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }

        return $this->repository->obtenerDetalleVenta($idVenta);
    }

    /**
     * Resumen por forma de pago por fechas
     */
    public function resumenFormasPago(string $fechaDesde = '', string $fechaHasta = ''): array {
        // Si ambas fechas están vacías, consultar todas las formas de pago
        if (empty($fechaDesde) && empty($fechaHasta)) {
            return $this->repository->resumenTodasFormasPago();
        }

        // Validar fechas si se proporcionan
        if (!empty($fechaDesde) && !$this->validarFecha($fechaDesde)) {
            throw new InvalidArgumentException("Formato de fecha 'desde' inválido. Use YYYY-MM-DD");
        }

        if (!empty($fechaHasta) && !$this->validarFecha($fechaHasta)) {
            throw new InvalidArgumentException("Formato de fecha 'hasta' inválido. Use YYYY-MM-DD");
        }

        // Si solo falta una fecha, usar valores por defecto
        if (empty($fechaDesde)) {
            $fechaDesde = '2000-01-01'; // Fecha muy antigua
        }
        if (empty($fechaHasta)) {
            $fechaHasta = date('Y-m-d'); // Fecha de hoy
        }

        if ($fechaDesde > $fechaHasta) {
            throw new InvalidArgumentException("La fecha desde no puede ser mayor a la fecha hasta");
        }

        return $this->repository->resumenFormasPago($fechaDesde, $fechaHasta);
    }

    /**
     * Resumen todas las formas de pago
     */
    public function resumenTodasFormasPago(): array {
        return $this->repository->resumenTodasFormasPago();
    }

    /**
     * Resumen formas de pago de hoy
     */
    public function resumenFormasPagoHoy(string $fechaHoy = ''): array {
        // Si no se proporciona fecha, usar la fecha de hoy
        if (empty($fechaHoy)) {
            $fechaHoy = date('Y-m-d');
        }

        if (!$this->validarFecha($fechaHoy)) {
            throw new InvalidArgumentException("Formato de fecha inválido. Use YYYY-MM-DD");
        }

        return $this->repository->resumenFormasPagoHoy($fechaHoy);
    }

    /**
     * Validar formato de fecha YYYY-MM-DD
     */
    private function validarFecha(string $fecha): bool {
        $d = \DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }
}

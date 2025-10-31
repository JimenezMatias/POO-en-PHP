<?php
namespace App\Servicios;

use App\Modelos\VentasRepository;
use InvalidArgumentException;

class VentasService {
    private VentasRepository $VentasRepository;

    public function __construct(VentasRepository $VentasRepository) {
        $this->VentasRepository = $VentasRepository;
    }

    public function iniciarVenta($idUsuario, $idCliente, $idTipoVenta) {
        return $this->VentasRepository->generarVenta($idUsuario, $idCliente, $idTipoVenta);
    }

    public function actualizarCabecera(int $idVenta, ?int $idCliente, ?int $idTipoVenta): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        if ($idCliente !== null && $idCliente <= 0) {
            throw new InvalidArgumentException("ID de cliente inválido");
        }
        if ($idTipoVenta !== null && $idTipoVenta <= 0) {
            throw new InvalidArgumentException("ID de tipo de venta inválido");
        }
        return $this->VentasRepository->actualizarCabecera($idVenta, $idCliente, $idTipoVenta);
    }

    public function agregarProducto(int $idVenta, string $codigo, float $cantidad): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        // Validación correcta: aceptar "0" como código válido
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("Código de producto es obligatorio");
        }
        if ($cantidad <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser mayor a cero");
        }
        return $this->VentasRepository->agregarProducto($idVenta, $codigo, $cantidad);
    }

    public function eliminarProducto(int $idVenta, string $codigo): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        // Validación correcta: aceptar "0" como código válido
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("Código de producto es obligatorio");
        }
        return $this->VentasRepository->eliminarProducto($idVenta, $codigo);
    }

    public function obtenerDetalle(int $idVenta): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        return $this->VentasRepository->obtenerDetalle($idVenta);
    }

    public function obtenerTotales(int $idVenta): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        return $this->VentasRepository->obtenerTotales($idVenta);
    }

    public function finalizarVenta(int $idVenta): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        return $this->VentasRepository->finalizarVenta($idVenta);
    }

    public function cancelarVenta(int $idVenta): array {
        if ($idVenta <= 0) {
            throw new InvalidArgumentException("ID de venta inválido");
        }
        return $this->VentasRepository->cancelarVenta($idVenta);
    }
}

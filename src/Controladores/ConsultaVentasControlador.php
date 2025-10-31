<?php
namespace App\Controladores;

use App\Servicios\ConsultaVentasService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use InvalidArgumentException;

class ConsultaVentasControlador {
    private ConsultaVentasService $service;

    public function __construct(ConsultaVentasService $service) {
        $this->service = $service;
    }

    /**
     * Consultar ventas por rango de fechas
     */
    public function consultarVentas(Request $request, Response $response): Response {
        $queryParams = $request->getQueryParams();
        $desde = $queryParams['desde'] ?? '';
        $hasta = $queryParams['hasta'] ?? '';

        try {
            $ventas = $this->service->consultarVentas($desde, $hasta);
            $response->getBody()->write(json_encode($ventas));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Consultar todas las ventas
     */
    public function consultarTodasVentas(Request $request, Response $response): Response {
        try {
            $ventas = $this->service->consultarTodasVentas();
            $response->getBody()->write(json_encode($ventas));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Consultar ventas de hoy
     */
    public function consultarVentasHoy(Request $request, Response $response): Response {
        $queryParams = $request->getQueryParams();
        $fecha = $queryParams['fecha'] ?? '';

        try {
            $ventas = $this->service->consultarVentasHoy($fecha);
            $response->getBody()->write(json_encode($ventas));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Obtener detalle de una venta
     */
    public function obtenerDetalleVenta(Request $request, Response $response, array $args): Response {
        $idVenta = (int) $args['id'];

        try {
            $detalle = $this->service->obtenerDetalleVenta($idVenta);
            $response->getBody()->write(json_encode($detalle));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Resumen por forma de pago por fechas
     */
    public function resumenFormasPago(Request $request, Response $response): Response {
        $queryParams = $request->getQueryParams();
        $desde = $queryParams['desde'] ?? '';
        $hasta = $queryParams['hasta'] ?? '';

        try {
            $resumen = $this->service->resumenFormasPago($desde, $hasta);
            $response->getBody()->write(json_encode($resumen));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Resumen todas las formas de pago
     */
    public function resumenTodasFormasPago(Request $request, Response $response): Response {
        try {
            $resumen = $this->service->resumenTodasFormasPago();
            $response->getBody()->write(json_encode($resumen));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Resumen formas de pago de hoy
     */
    public function resumenFormasPagoHoy(Request $request, Response $response): Response {
        $queryParams = $request->getQueryParams();
        $fecha = $queryParams['fecha'] ?? '';

        try {
            $resumen = $this->service->resumenFormasPagoHoy($fecha);
            $response->getBody()->write(json_encode($resumen));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            // Log del error para debugging
            error_log("Error en consultarVentas: " . $e->getMessage());
            $response->getBody()->write(json_encode(['error' => 'Error interno del servidor']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}

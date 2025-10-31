<?php
namespace App\Controladores;

use App\Servicios\VentasService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use InvalidArgumentException;

class VentasControlador {
    private VentasService $VentasService;

    public function __construct(VentasService $VentasService) {
        $this->VentasService = $VentasService;
    }

    public function iniciarVenta(Request $request, Response $response): Response {
        $params = $request->getParsedBody();

        $idUsuario = $params['id_usuario'] ?? null;
        $idCliente = $params['id_cliente'] ?? null;
        $idTipoVenta = $params['id_tipo_venta'] ?? null;

        if (!$idUsuario || !$idCliente || !$idTipoVenta) {
            $response->getBody()->write(json_encode(['error' => 'Faltan parámetros requeridos']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $result = $this->VentasService->iniciarVenta($idUsuario, $idCliente, $idTipoVenta);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function actualizarCabecera(Request $request, Response $response, array $args): Response {
        $params = $request->getParsedBody();
        $idVenta = (int)$args['id'];

        $idCliente = isset($params['id_cliente']) ? (int)$params['id_cliente'] : null;
        $idTipoVenta = isset($params['id_tipo_venta']) ? (int)$params['id_tipo_venta'] : null;

        // Validar que al menos uno de los parámetros esté presente
        if ($idCliente === null && $idTipoVenta === null) {
            $response->getBody()->write(json_encode(['error' => 'Debe proporcionar al menos un parámetro para actualizar']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $result = $this->VentasService->actualizarCabecera($idVenta, $idCliente, $idTipoVenta);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function agregarProducto(Request $request, Response $response, array $args): Response {
        $params = $request->getParsedBody();
        $idVenta = (int)$args['id'];

        $codigo = $params['codigo'] ?? null;
        $cantidad = $params['cantidad'] ?? null;

        // Validación correcta: aceptar "0" como código válido
        if ($codigo === null || $codigo === '' || $cantidad === null || $cantidad <= 0) {
            $response->getBody()->write(json_encode(['error' => 'Faltan parámetros requeridos']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $result = $this->VentasService->agregarProducto($idVenta, $codigo, (float)$cantidad);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function eliminarProducto(Request $request, Response $response, array $args): Response {
        $idVenta = (int)$args['id'];
        $codigo = $args['codigo'] ?? null;

        // Validación correcta: aceptar "0" como código válido
        if ($codigo === null || $codigo === '') {
            $response->getBody()->write(json_encode(['error' => 'Código de producto requerido']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $result = $this->VentasService->eliminarProducto($idVenta, $codigo);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function obtenerDetalle(Request $request, Response $response, array $args): Response {
        $idVenta = (int)$args['id'];

        try {
            $result = $this->VentasService->obtenerDetalle($idVenta);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function obtenerTotales(Request $request, Response $response, array $args): Response {
        $idVenta = (int)$args['id'];

        try {
            $result = $this->VentasService->obtenerTotales($idVenta);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function finalizarVenta(Request $request, Response $response, array $args): Response {
        $idVenta = (int)$args['id'];

        try {
            $result = $this->VentasService->finalizarVenta($idVenta);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function cancelarVenta(Request $request, Response $response, array $args): Response {
        $idVenta = (int)$args['id'];

        try {
            $result = $this->VentasService->cancelarVenta($idVenta);
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}

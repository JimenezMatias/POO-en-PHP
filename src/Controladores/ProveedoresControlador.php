<?php
namespace App\Controladores;

use App\Servicios\ProveedoresService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use InvalidArgumentException;

class ProveedoresControlador {
    private ProveedoresService $service;

    public function __construct(ProveedoresService $service) {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response {
        $data = $this->service->listar();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function crear(Request $request, Response $response): Response {
        $datos = (array)$request->getParsedBody();

        try {
            $this->service->crear($datos);
            $response->getBody()->write(json_encode(['mensaje' => 'Proveedor creado correctamente']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Error interno']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function editar(Request $request, Response $response, array $args): Response {
        $datos = (array)$request->getParsedBody();
        $id = (int)$args['id'];

        try {
            $this->service->editar($id, $datos);
            $response->getBody()->write(json_encode(['mensaje' => 'Proveedor actualizado correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    public function eliminar(Request $request, Response $response, array $args): Response {
        $id = (int)$args['id'];

        try {
            $this->service->eliminar($id);
            $response->getBody()->write(json_encode(['mensaje' => 'Proveedor eliminado correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
}

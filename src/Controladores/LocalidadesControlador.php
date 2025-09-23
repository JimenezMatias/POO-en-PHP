<?php
namespace App\Controladores;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Servicios\LocalidadesService;

class LocalidadesControlador {
    private LocalidadesService $localidadesService;

    public function __construct(LocalidadesService $localidadesService) {
        $this->localidadesService = $localidadesService;
    }

    // Listar todas las localidades
    public function listar(Request $request, Response $response): Response {
        $localidades = $this->localidadesService->listar();
        $response->getBody()->write(json_encode($localidades));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Crear nueva localidad
    public function crear(Request $request, Response $response): Response {
        $datos = (array)$request->getParsedBody();

        try {
            $this->localidadesService->crear(
                (int)$datos['cp'],
                $datos['localidad'],
                (int)$datos['id_provincia']
            );

            $response->getBody()->write(json_encode(['mensaje' => 'Localidad creada correctamente']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    // Editar localidad
    public function editar(Request $request, Response $response, array $args): Response {
        $cp = (int)$args['cp'];
        $datos = (array)$request->getParsedBody();

        try {
            $this->localidadesService->editar($cp, $datos);
            $response->getBody()->write(json_encode(['mensaje' => 'Localidad editada correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    // Eliminar localidad
    public function eliminar(Request $request, Response $response, array $args): Response {
        $cp = (int)$args['cp'];

        $this->localidadesService->eliminar($cp);
        $response->getBody()->write(json_encode(['mensaje' => 'Localidad eliminada correctamente']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php
namespace App\Controladores;

use App\Servicios\RespIvaService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RespIvaControlador {
    private RespIvaService $service;

    public function __construct(RespIvaService $service) {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response {
        try {
            $data = $this->service->listar();
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function obtenerPorId(Request $request, Response $response, array $args): Response {
        try {
            $id = (int)$args['id'];
            $data = $this->service->obtenerPorId($id);
            
            if (!$data) {
                $response->getBody()->write(json_encode(['error' => 'Responsabilidad IVA no encontrada']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}


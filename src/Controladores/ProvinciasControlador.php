<?php
namespace App\Controladores;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Servicios\ProvinciasService;

class ProvinciasControlador {
    private ProvinciasService $provinciasService;

    public function __construct(ProvinciasService $provinciasService) {
        $this->provinciasService = $provinciasService;
    }

    public function listar(Request $request, Response $response): Response {
        $provincias = $this->provinciasService->listar();
        $response->getBody()->write(json_encode($provincias));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php
namespace App\Controladores;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Servicios\UnidadesMedidasService;

class UnidadesMedidasControlador {
    private UnidadesMedidasService $unidadesMedidasService;

    public function __construct(UnidadesMedidasService $unidadesMedidasService) {
        $this->unidadesMedidasService = $unidadesMedidasService;
    }

    public function listar(Request $request, Response $response): Response {
        $unidades = $this->unidadesMedidasService->listar();
        $response->getBody()->write(json_encode($unidades));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php
namespace App\Controladores;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Servicios\TasasIvaService;

class TasasIvaControlador {
    private TasasIvaService $tasasIvaService;

    public function __construct(TasasIvaService $tasasIvaService) {
        $this->tasasIvaService = $tasasIvaService;
    }

    public function listar(Request $request, Response $response): Response {
        $tasas = $this->tasasIvaService->listar();
        $response->getBody()->write(json_encode($tasas));
        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php
namespace App\Controladores;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Servicios\FormasDePagoService;
use App\Config\Database;
use App\Modelos\FormasDePagoRepository;

class FormasDePagoControlador
{
    private FormasDePagoService $FormasDePagoService;

    public function __construct(FormasDePagoService $FormasDePagoService)
    {
        $this->FormasDePagoService = $FormasDePagoService;
    }

    //Metodos

    // GET /formasDePago
    public function listar(Request $request, Response $response, $args)
    {
        $resultado = $this->FormasDePagoService->listarFormasDePago();
        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

    // POST /formasDePago
    public function crear(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $nombre = $data['nombre'] ?? '';
        $resultado = $this->FormasDePagoService->crearFormaDePago($nombre);
        $response->getBody()->write(json_encode(["id" => $resultado]));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(201);
    }

    // PUT /formasDePago/{id}
    public function editar(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $resultado = $this->FormasDePagoService->editarFormaDePago($id, $data);
        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

    // DELETE /formasDePago/{id}
    public function eliminar(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $resultado = $this->FormasDePagoService->eliminarFormaDePago($id);
        $response->getBody()->write(json_encode(["eliminado" => $resultado]));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

}

?>
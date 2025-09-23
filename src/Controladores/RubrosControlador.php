<?php
namespace App\Controladores;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Servicios\RubrosService;

class RubrosControlador
{
    private RubrosService $RubrosService;

    public function __construct(RubrosService $RubrosService)
    {
        $this->RubrosService = $RubrosService;
    }

    //Metodos

    // GET /Rubros
    public function listar(Request $request, Response $response, $args)
    {
        $resultado = $this->RubrosService->listarRubro();
        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

    // POST /Rubros
    public function crear(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $nombre = $data['nombre'] ?? '';
        $resultado = $this->RubrosService->crearRubro($nombre);
        $response->getBody()->write(json_encode(["id" => $resultado]));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(201);
    }

    // PUT /Rubros/{id}
    public function editar(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $resultado = $this->RubrosService->editarRubro($id, $data);
        $response->getBody()->write(json_encode($resultado));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

    // DELETE /Rubros/{id}
    public function eliminar(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $resultado = $this->RubrosService->eliminarRubro($id);
        $response->getBody()->write(json_encode(["eliminado" => $resultado]));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(200);
    }

}

?>
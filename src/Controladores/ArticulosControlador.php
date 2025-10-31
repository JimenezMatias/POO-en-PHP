<?php
namespace App\Controladores;

use App\Servicios\ArticulosService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use InvalidArgumentException;

class ArticulosControlador {
    private ArticulosService $service;

    public function __construct(ArticulosService $service) {
        $this->service = $service;
    }

    // Listar todos los productos
    public function listar(Request $request, Response $response): Response {
        $data = $this->service->listar();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    // Crear un producto
    public function crear(Request $request, Response $response): Response {
        $datos = (array)$request->getParsedBody();

        try {
            $this->service->crear($datos);
            $response->getBody()->write(json_encode(['mensaje' => 'Producto creado correctamente']));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Error interno']));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    // Editar un producto por código
    public function editar(Request $request, Response $response, array $args): Response {
        $datos = (array)$request->getParsedBody();
        $codigo = $args['codigo'];

        try {
            $this->service->editar($codigo, $datos);
            $response->getBody()->write(json_encode(['mensaje' => 'Producto actualizado correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    // Eliminar un producto por código
    public function eliminar(Request $request, Response $response, array $args): Response {
        $codigo = $args['codigo'];

        try {
            $this->service->eliminar($codigo);
            $response->getBody()->write(json_encode(['mensaje' => 'Producto eliminado correctamente']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    // Obtener un producto por código (para Stock)
    public function obtenerPorCodigo(Request $request, Response $response, array $args): Response {
        $codigo = $args['codigo'];

        try {
            $producto = $this->service->obtenerPorCodigo($codigo);
            $response->getBody()->write(json_encode($producto));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    // Sumar stock (permite positivos y negativos)
    public function sumarStock(Request $request, Response $response, array $args): Response {
        $codigo = $args['codigo'];
        $datos = (array)$request->getParsedBody();

        try {
            if (!isset($datos['cantidad'])) {
                throw new InvalidArgumentException("La cantidad es obligatoria");
            }

            $cantidad = (float)$datos['cantidad'];
            $productoActualizado = $this->service->sumarStock($codigo, $cantidad);
            
            $mensaje = $cantidad > 0 
                ? "Stock actualizado correctamente: +{$cantidad} unidades" 
                : "Stock actualizado correctamente: {$cantidad} unidades";
            
            $response->getBody()->write(json_encode([
                'mensaje' => $mensaje,
                'producto' => $productoActualizado
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

    // Actualizar precio de venta
    public function actualizarPrecio(Request $request, Response $response, array $args): Response {
        $codigo = $args['codigo'];
        $datos = (array)$request->getParsedBody();

        try {
            if (!isset($datos['precio'])) {
                throw new InvalidArgumentException("El precio es obligatorio");
            }

            $precio = (float)$datos['precio'];
            $productoActualizado = $this->service->actualizarPrecio($codigo, $precio);
            
            $response->getBody()->write(json_encode([
                'mensaje' => "Precio actualizado correctamente: $" . number_format($precio, 2),
                'producto' => $productoActualizado
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
}

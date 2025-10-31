<?php

use Slim\App;
use App\Controladores\ClientesControlador;
use App\Modelos\ClientesRepository;
use App\Servicios\ClientesService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {
    // Instanciar dependencias
    $database = new Database();
    $repository = new ClientesRepository($database->getConnection());
    $service = new ClientesService($repository);
    $controller = new ClientesControlador($service);

    // Instanciar AuthService y JWTMiddleware
    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    // Rutas agrupadas para /clientes
    $app->group('/clientes', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);              // GET /clientes
        $group->get('/{id}', [$controller, 'obtenerPorId']);   // GET /clientes/{id}
        $group->post('', [$controller, 'crear']);              // POST /clientes
        $group->put('/{id}', [$controller, 'editar']);         // PUT /clientes/{id}
        $group->delete('/{id}', [$controller, 'eliminar']);    // DELETE /clientes/{id}
    })->add($jwtMiddleware);
};


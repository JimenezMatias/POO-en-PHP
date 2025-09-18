<?php

use Slim\App;
use App\Controladores\FormasDePagoControlador;
use App\Modelos\FormasDePagoRepository;
use App\Servicios\FormasDePagoService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;


return function(App $app) {

    // Instanciar dependencias
    $database = new Database();
    $repository = new FormasDePagoRepository($database->getConnection());
    $service = new FormasDePagoService($repository);
    $controller = new FormasDePagoControlador($service);

    // Instanciar AuthService y JWTMiddleware
    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    // Rutas agrupadas para /formas-de-pago
    $app->group('/formas-de-pago', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);         // GET /formas-de-pago
        $group->post('', [$controller, 'crear']);         // POST /formas-de-pago
        $group->put('/{id}', [$controller, 'editar']);    // PUT /formas-de-pago/{id}
        $group->delete('/{id}', [$controller, 'eliminar']); // DELETE /formas-de-pago/{id}
    })->add($jwtMiddleware); 

};


?>
<?php

use Slim\App;
use App\Controladores\RubrosControlador;
use App\Modelos\RubrosRepository;
use App\Servicios\RubrosService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;


return function(App $app) {

    // Instanciar dependencias
    $database = new Database();
    $repository = new RubrosRepository($database->getConnection());
    $service = new RubrosService($repository);
    $controller = new RubrosControlador($service);

    // Instanciar AuthService y JWTMiddleware
    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    // Rutas agrupadas para /formas-de-pago
    $app->group('/rubros', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);         // GET /Rubros
        $group->post('', [$controller, 'crear']);         // POST /Rubros
        $group->put('/{id}', [$controller, 'editar']);    // PUT /Rubros/{id}
        $group->delete('/{id}', [$controller, 'eliminar']); // DELETE /Rubros/{id}
    })->add($jwtMiddleware); 

};

?>
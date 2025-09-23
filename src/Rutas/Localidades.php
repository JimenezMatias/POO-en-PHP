<?php

use Slim\App;
use App\Controladores\LocalidadesControlador;
use App\Modelos\LocalidadesRepository;
use App\Servicios\LocalidadesService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {

    // Instanciar dependencias
    $database = new Database();
    $repository = new LocalidadesRepository($database->getConnection());
    $service = new LocalidadesService($repository);
    $controller = new LocalidadesControlador($service);

    // Instanciar AuthService y JWTMiddleware
    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    // Rutas agrupadas para /localidades
    $app->group('/localidades', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);           // GET /localidades
        $group->post('', [$controller, 'crear']);           // POST /localidades
        $group->put('/{cp}', [$controller, 'editar']);      // PUT /localidades/{cp}
        $group->delete('/{cp}', [$controller, 'eliminar']); // DELETE /localidades/{cp}
    })->add($jwtMiddleware); 

};
?>

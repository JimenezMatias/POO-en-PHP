<?php

use Slim\App;
use App\Config\Database;
use App\Modelos\TiposDocRepository;
use App\Servicios\TiposDocService;
use App\Controladores\TiposDocControlador;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {
    
    $database = new Database();
    $repository = new TiposDocRepository($database->getConnection());
    $service = new TiposDocService($repository);
    $controller = new TiposDocControlador($service);


    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/tipos-doc', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);
        $group->get('/{id}', [$controller, 'obtenerPorId']);
    })->add($jwtMiddleware);
};


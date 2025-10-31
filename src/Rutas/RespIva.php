<?php

use Slim\App;
use App\Config\Database;
use App\Modelos\RespIvaRepository;
use App\Servicios\RespIvaService;
use App\Controladores\RespIvaControlador;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {



    // Instanciar dependencias
    $database = new Database();
    $repository = new RespIvaRepository($database->getConnection());
    $service = new RespIvaService($repository);
    $controller = new RespIvaControlador($service);
    
    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/resp-iva', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);
        $group->get('/{id}', [$controller, 'obtenerPorId']);
    })->add($jwtMiddleware);
};


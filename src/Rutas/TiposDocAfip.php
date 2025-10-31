<?php

use Slim\App;
use App\Config\Database;
use App\Modelos\TiposDocAfipRepository;
use App\Servicios\TiposDocAfipService;
use App\Controladores\TiposDocAfipControlador;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {

    $database = new Database();

    $repository = new TiposDocAfipRepository($database->getConnection());
    $service = new TiposDocAfipService($repository);
    $controller = new TiposDocAfipControlador($service);

    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);


    $app->group('/tipos-doc-afip', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']);
        $group->get('/{id}', [$controller, 'obtenerPorId']);
    })->add($jwtMiddleware);
};


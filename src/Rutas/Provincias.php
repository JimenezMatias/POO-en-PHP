<?php

use Slim\App;
use App\Controladores\ProvinciasControlador;
use App\Modelos\ProvinciasRepository;
use App\Servicios\ProvinciasService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {

    $database = new Database();
    $repository = new ProvinciasRepository($database->getConnection());
    $service = new ProvinciasService($repository);
    $controller = new ProvinciasControlador($service);

    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    // Solo listar provincias
    $app->group('/provincias', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']); // GET /provincias
    })->add($jwtMiddleware);
};

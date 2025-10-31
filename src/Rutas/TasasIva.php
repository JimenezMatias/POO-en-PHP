<?php

use Slim\App;
use App\Controladores\TasasIvaControlador;
use App\Modelos\TasasIvaRepository;
use App\Servicios\TasasIvaService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {

    $database = new Database();
    $repository = new TasasIvaRepository($database->getConnection());
    $service = new TasasIvaService($repository);
    $controller = new TasasIvaControlador($service);

    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/tasas_iva', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']); // GET /tasas-iva
    })->add($jwtMiddleware);
};

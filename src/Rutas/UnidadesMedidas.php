<?php

use Slim\App;
use App\Controladores\UnidadesMedidasControlador;
use App\Modelos\UnidadesMedidasRepository;
use App\Servicios\UnidadesMedidasService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {

    $database = new Database();
    $repository = new UnidadesMedidasRepository($database->getConnection());
    $service = new UnidadesMedidasService($repository);
    $controller = new UnidadesMedidasControlador($service);

    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/unidades_medida', function ($group) use ($controller) {
        $group->get('', [$controller, 'listar']); // GET /unidades-medidas
    })->add($jwtMiddleware);
};

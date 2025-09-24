<?php
use Slim\App;
use App\Modelos\UbicacionesRepository;
use App\Servicios\UbicacionesService;
use App\Controladores\UbicacionesControlador;
use App\Config\Database;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;
use App\Middlewares\JWTMiddleware;

return function(App $app) {
    $db = new Database();
    $repo = new UbicacionesRepository($db->getConnection());
    $service = new UbicacionesService($repo);
    $controller = new UbicacionesControlador($service);

    $authService = new AuthService(new UserRepository($db->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/ubicaciones', function($group) use ($controller) {
        $group->get('', [$controller, 'listar']);
        $group->post('', [$controller, 'crear']);
        $group->put('/{id}', [$controller, 'editar']);
        $group->delete('/{id}', [$controller, 'eliminar']);
    })->add($jwtMiddleware);
};

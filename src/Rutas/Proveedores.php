<?php
use Slim\App;
use App\Modelos\ProveedoresRepository;
use App\Servicios\ProveedoresService;
use App\Controladores\ProveedoresControlador;
use App\Config\Database;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;
use App\Middlewares\JWTMiddleware;

return function(App $app) {
    $db = new Database();
    $repo = new ProveedoresRepository($db->getConnection());
    $service = new ProveedoresService($repo);
    $controller = new ProveedoresControlador($service);

    $authService = new AuthService(new UserRepository($db->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/proveedores', function($group) use ($controller) {
        $group->get('', [$controller, 'listar']);
        $group->post('', [$controller, 'crear']);
        $group->put('/{id}', [$controller, 'editar']);
        $group->delete('/{id}', [$controller, 'eliminar']);
    })->add($jwtMiddleware);
};

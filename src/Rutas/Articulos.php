<?php
use Slim\App;
use App\Modelos\ArticulosRepository;
use App\Servicios\ArticulosService;
use App\Controladores\ArticulosControlador;
use App\Config\Database;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;
use App\Middlewares\JWTMiddleware;

return function(App $app) {
    $db = new Database();
    $repo = new ArticulosRepository($db->getConnection());
    $service = new ArticulosService($repo);
    $controller = new ArticulosControlador($service);

    $authService = new AuthService(new UserRepository($db->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/articulos', function($group) use ($controller) {
        $group->get('', [$controller, 'listar']);                     // GET /articulos
        $group->post('', [$controller, 'crear']);                     // POST /articulos
        $group->put('/{codigo}', [$controller, 'editar']);           // PUT /articulos/{codigo}
        $group->delete('/{codigo}', [$controller, 'eliminar']);      // DELETE /articulos/{codigo}
    })->add($jwtMiddleware);
};

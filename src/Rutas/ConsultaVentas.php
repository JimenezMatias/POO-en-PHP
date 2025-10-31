<?php
use Slim\App;
use App\Modelos\ConsultaVentasRepository;
use App\Servicios\ConsultaVentasService;
use App\Controladores\ConsultaVentasControlador;
use App\Config\Database;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;
use App\Middlewares\JWTMiddleware;

return function(App $app) {
    $db = new Database();
    $repo = new ConsultaVentasRepository($db->getConnection());
    $service = new ConsultaVentasService($repo);
    $controller = new ConsultaVentasControlador($service);

    $authService = new AuthService(new UserRepository($db->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    $app->group('/consulta-ventas', function($group) use ($controller) {
        // Rutas específicas primero (para evitar conflictos con parámetros)
        $group->get('/resumen/todas', [$controller, 'resumenTodasFormasPago']);
        $group->get('/resumen/hoy', [$controller, 'resumenFormasPagoHoy']);
        $group->get('/todas', [$controller, 'consultarTodasVentas']);
        $group->get('/hoy', [$controller, 'consultarVentasHoy']);
        $group->get('/{id}/detalle', [$controller, 'obtenerDetalleVenta']);
        
        // Rutas con query params (al final)
        $group->get('/resumen', [$controller, 'resumenFormasPago']);
        $group->get('', [$controller, 'consultarVentas']);
    })->add($jwtMiddleware);
};

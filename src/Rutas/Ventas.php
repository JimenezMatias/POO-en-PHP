<?php

use Slim\App;
use App\Controladores\VentasControlador;
use App\Modelos\VentasRepository;
use App\Servicios\VentasService;
use App\Config\Database;
use App\Middlewares\JWTMiddleware;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;

return function(App $app) {

    // Instanciar dependencias base
    $database = new Database();
    $repository = new VentasRepository($database->getConnection());
    $service = new VentasService($repository);
    $controller = new VentasControlador($service);

    // Instanciar AuthService y JWTMiddleware
    $authService = new AuthService(new UserRepository($database->getConnection()), new JWTService());
    $jwtMiddleware = new JWTMiddleware($authService);

    // Grupo de rutas para /ventas
    $app->group('/ventas', function ($group) use ($controller) {

        // Iniciar venta
        $group->post('/iniciar', [$controller, 'iniciarVenta']);
        
        // Actualizar cabecera (cliente/forma de pago)
        $group->put('/{id}/cabecera', [$controller, 'actualizarCabecera']);
        
        // Gestión de productos en el detalle
        $group->post('/{id}/detalle', [$controller, 'agregarProducto']);
        $group->delete('/{id}/detalle/{codigo}', [$controller, 'eliminarProducto']);
        $group->get('/{id}/detalle', [$controller, 'obtenerDetalle']);
        
        // Obtener totales de la venta
        $group->get('/{id}/totales', [$controller, 'obtenerTotales']);
        
        // Finalizar/Cancelar venta
        $group->post('/{id}/finalizar', [$controller, 'finalizarVenta']);
        $group->post('/{id}/cancelar', [$controller, 'cancelarVenta']);

    })->add($jwtMiddleware);
};

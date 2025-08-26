<?php

use App\Controladores\AuthControlador;

return function($app) {
    // Registro POST
    $app->post('/auth/register', [AuthControlador::class, 'register']);

    // Registro GET
    $app->get('/register', function($request, $response, $args) {
        ob_start();
        include __DIR__ . '/../Vistas/registro.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });


    // Login POST
    $app->post('/auth/login', [AuthControlador::class, 'login']);

    // Login GET
    $app->get('/login', function($request, $response, $args) {
        ob_start();
        include __DIR__ . '/../Vistas/login.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });

    // Dashboard GET
    $app->get('/dashboard', function($request, $response, $args) {
        ob_start();
        include __DIR__ . '/../Vistas/dashboard.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });
};

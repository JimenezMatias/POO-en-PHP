<?php

use Slim\App;
use App\Controladores\AuthControlador;
use App\Middlewares\JWTMiddleware;
use App\Modelos\UserRepository;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Config\Database; 

return function(App $app) {

    // Instanciar servicios y controlador
    
    $jwtService = new JWTService();
    $authService = new AuthService(new UserRepository(new Database()->getConnection()), $jwtService);
    $authController = new AuthControlador($authService);

    // Registro POST
    $app->post('/auth/register', [$authController, 'register']);

    // Login POST 
    $app->post('/auth/login', [$authController, 'login']);

};

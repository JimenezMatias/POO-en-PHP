<?php

use Slim\App;
use App\Controladores\AuthController;
use App\Middlewares\JWTMiddleware;
use App\Modelos\UserRepository;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Servicios\PasswordHasher;

return function(App $app) {

    // Instanciar servicios y controlador
    $userRepo = new UserRepository();
    $jwtService = new JWTService();
    $passwordHasher = new PasswordHasher();
    $authService = new AuthService($userRepo, $jwtService, $passwordHasher);
    $authController = new AuthController($authService);

    // Registro POST
    $app->post('/auth/register', [$authController, 'register']);

    // Registro GET - mostrar formulario
    $app->get('/register', function($request, $response, $args) {
        ob_start();
        include __DIR__ . '/../Vistas/registro.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });

    // Login POST 
    $app->post('/auth/login', [$authController, 'login']);

    // Login GET - mostrar formulario
    $app->get('/login', function($request, $response, $args) {
        ob_start();
        include __DIR__ . '/../Vistas/login.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    });

    // Dashboard GET - ruta protegida por JWT
    $app->get('/dashboard', function($request, $response, $args) {
        ob_start();
        include __DIR__ . '/../Vistas/dashboard.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);
        return $response;
    })->add(new JWTMiddleware());
};

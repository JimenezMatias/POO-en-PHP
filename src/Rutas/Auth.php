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
        return $response->withHeader('Content-Type', 'text/html');
    });


    //test conexion db
    $app->get('/test-db', function($request, $response, $args) {
        try {
            $db = new \App\Config\Database();
            $pdo = $db->getConnection();
            $response->getBody()->write("Conexión exitosa a la base de datos.");
        } catch (\Exception $e) {
            $response->getBody()->write("Error: " . $e->getMessage());
        }
        
        return $response;
    });
};

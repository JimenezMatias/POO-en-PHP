<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Config\AppConfig;
use App\Controladores\AuthControlador;
use App\Middlewares\JWTMiddleware;
use Tuupola\Middleware\HttpbasicAuthentication;

#--- Carga .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

#---Carga app Slim
$app = AppFactory::create();
$app->addBodyParsingMiddleware(); 

#--- Config y servicios
$config = new AppConfig();
$authService = $config->getAuthService();


#---Middlewares
$app = new HttpBasicAuthentication([
    "users" => [
        $_ENV['BASIC_USER'] => $_ENV['BASIC_PASS']
    ],
    "path" => ["/admin"],
    "ignore" => ["/login", "/register"] // rutas públicas
]);

$jwtMiddleware = new JWTMiddleware($authService);

// Controlador
$authController = new AuthController($authService);

// Rutas públicas
$app->post('/login', [$authController, 'login']);
$app->post('/register', [$authController, 'register']);

// Rutas privadas (JWT)
$app->group('', function($group){
    $group->get('/dashboard', function($request, $response){
        $user = $request->getAttribute('user');
        $response->getBody()->write(json_encode([
            'mensaje' => 'Bienvenido al dashboard',
            'user' => $user
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    });
})->add($jwtMiddleware);

// Admin routes (Basic Auth)
$app->group('/admin', function($group){
    $group->get('/panel', function($request, $response){
        $response->getBody()->write(json_encode(['mensaje' => 'Panel admin']));
        return $response->withHeader('Content-Type', 'application/json');
    });
})->add($basicAuthMiddleware);

// Ejecutar app
$app->run();

?>
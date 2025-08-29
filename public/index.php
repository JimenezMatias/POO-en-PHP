<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Config\AppConfig;
use App\Controladores\AuthControlador;
use App\Middlewares\JWTMiddleware;
use Tuupola\Middleware\HttpbasicAuthentication;

//Carga .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

//Carga app Slim
$app = AppFactory::create();
$app->addBodyParsingMiddleware(); 



//Middlewares
$app->add(new HttpBasicAuthentication([
    "users" => [
        $_ENV['BASIC_USER'] => $_ENV['BASIC_PASS']
    ],
    "path" => ["/auth/login"],
    "secure" => false
]));

// rutas
(require __DIR__ . '/../src/Rutas/Auth.php')($app);


$app->group('/dashboard', function ($group) {
    // Aquí irían las rutas del dashboard (ejemplo: perfil, tareas, etc.)
    $group->get('', function ($request, $response) {
        $response->getBody()->write(json_encode([
            "message" => "Bienvenido al dashboard protegido con JWT"
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    });
})->add(new JWTMiddleware());


// Ejecutar app
$app->run();

?>
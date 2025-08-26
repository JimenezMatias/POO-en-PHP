<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\HttpbasicAuthentication;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();


// Rutas de Auth (register, login)
(require __DIR__ . '/../src/Rutas/Auth.php')($app);

// Redirección simple de raíz al login
$app->get('/api/test', function (Request $request, Response $response) {
    return $response
        ->withHeader('Location', '/login')
        ->withStatus(302);
});

$app->add(new HttpbasicAuthentication([
    "path" => "/api",
    "secure" => false,
    "users" => [
        "root" => "123",
    ]
    
])); 
    
$app->run();

?>
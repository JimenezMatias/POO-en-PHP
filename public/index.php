<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Config\AppConfig;
use App\Controladores\AuthControlador;
use App\Middlewares\JWTMiddleware;
use Tuupola\Middleware\HttpbasicAuthentication;
use App\Servicios\AuthService;
use App\Servicios\JWTService;
use App\Modelos\UserRepository;
use App\Config\Database;

//Carga .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

//Carga app Slim
$app = AppFactory::create();
$app->addBodyParsingMiddleware(); 

//Middlewares
$app->add(new HttpBasicAuthentication([
    "path" => ["/auth/login"],
    "secure" => false,

    // Validación dinámica
    "authenticator" => function ($arguments) {
        $username = $arguments["user"];
        $password = $arguments["password"];

        // Repositorio de usuarios
        $userRepository = new UserRepository((new Database())->getConnection());
        $user = $userRepository->findByNombre($username);

        // Verifica si existe y la contraseña es válida
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    },

    // Antes de pasar al controlador
    "before" => function ($request, $arguments) {
        return $request->withAttribute("user", $arguments["user"]);
    },

    // Manejo de errores
    "error" => function ($response, $arguments) {
        $data = [
            "status" => "error",
            "message" => $arguments["message"]
        ];

        $body = $response->getBody();
        $body->write(json_encode($data, JSON_UNESCAPED_SLASHES));

        return $response
            ->withBody($body)
            ->withHeader("Content-Type", "application/json")
            ->withoutHeader("WWW-Authenticate");
    }
]));


// rutas
(require __DIR__ . '/../src/Rutas/Auth.php')($app);

$app->group('/protegido', function ($group) {
    // Aquí irían las rutas del dashboard (ejemplo: perfil, tareas, etc.)
    $group->get('', function ($request, $response) {
        $userClaims = $request->getAttribute('user');
        $payload = [
            "status" => "success",
            "message" => "Bienvenido " . ($userClaims['nombre'] ?? "Usuario")
        ];
        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json');
    });
})->add(new JWTMiddleware(new AuthService(new UserRepository(new Database()->getConnection()), new JWTService())));


// Ejecutar app
$app->run();


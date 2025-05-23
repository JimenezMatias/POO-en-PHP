<?php
require_once __DIR__ . '/Autoloader/Autoloader.php';
require_once __DIR__ . '/Ayudantes/Funciones.php';

/*
Ejercicio 1
use Modelos\Usuario;

$usuario = new Usuario();
echo $usuario->decirHola();
*/

/*
Ejercicio 2
use Modelos\Empleado;

$empleado = new Empleado();
echo $empleado->saludar();
echo $empleado->trabajar(); 
*/

/*
Ejercicio 3
use Proveedor\Herramientas\Ayudante as AyudaProveedor;

echo AyudaProveedor::ayudar();
*/

/*
Ejercicio 6
use Controladores\ControladorUsuario;

$controlador = new ControladorUsuario();
echo $controlador->inicio();
*/

/*
Ejercicio 7
use Utilidades\Matematica;

$controlador = new ControladorUsuario();
echo Matematica::sumar(5, 7)
*/

/*
Ejercicio 8
use Configuracion\ConfiguracionApp;

echo ConfiguracionApp::NOMBRE_APP;
*/

/*
Ejercicio 9
use Ayudantes\saludar;

echo saludar();
*/

//Ejercicio 10
use Controladores\ControladorUsuario;

$controlador = new ControladorUsuario();
$controlador->mostrarNombre();

?>
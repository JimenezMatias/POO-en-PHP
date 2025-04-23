**Ejercicio 2**  
   Define una clase `Usuario` con una propiedad privada `edad`. Agrega un constructor, un método `getEdad` y un método `setEdad` que solo acepte valores mayores a 0. Instancia un objeto y verifica su comportamiento.
/
<?php
class Usuario {
    // Propiedad privada
    private $edad;

    // Constructor 
    public function __construct($edadInicial) {
        // Validar que la edad inicial sea mayor a 0
        if ($edadInicial > 0) {
            $this->edad = $edadInicial;
        } else {
            echo "La edad inicial debe ser mayor a 0.\n";
            $this->edad = null; // Inicialización segura
        }
    }

    // Método para consultar la edad
    public function getEdad() {
        return $this->edad;
    }

    // Método para asignar una nueva edad
    public function setEdad($nuevaEdad) {
        if ($nuevaEdad > 0) {
            $this->edad = $nuevaEdad;
            echo "La edad ha sido actualizada a $nuevaEdad años.\n";
        } else {
            echo "La edad debe ser mayor a 0.\n";
        }
    }
}


$usuario = new Usuario(25); // Crear objeto con edad inicial válida
echo "Edad inicial: " . $usuario->getEdad() . " años.\n"; // Consultar edad

$usuario->setEdad(30); // Asignar nueva edad válida
$usuario->setEdad(-5); // Intentar asignar una edad no válida
echo "Edad final: " . $usuario->getEdad() . " años.\n"; // Consultar edad final
?>

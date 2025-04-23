**Ejercicio 4**  
   Define una clase base `Figura` con un método abstracto `calcularArea`. Crea una subclase `Cuadrado` con la propiedad `lado` e implementa `calcularArea`. Instancia y muestra el área.
/
<?php
// Clase base abstracta
abstract class Figura {
    // Método abstracto que debe ser implementado por las subclases
    abstract public function calcularArea();
}

// Subclase Cuadrado que hereda de Figura
class Cuadrado extends Figura {
    // Propiedad privada
    private $lado;

    // Constructor para inicializar el valor del lado
    public function __construct($lado) {
        if ($lado > 0) {
            $this->lado = $lado;
        } else {
            echo "El lado debe ser mayor a 0.\n";
            $this->lado = null; // Inicialización segura
        }
    }

    // Implementación del método abstracto
    public function calcularArea() {
        if ($this->lado !== null) {
            return $this->lado * $this->lado;
        } else {
            echo "El área no puede calcularse porque el lado es inválido.\n";
            return null;
        }
    }
}

// Prueba con un objeto
$miCuadrado = new Cuadrado(5); // Crear un cuadrado con un lado válido
$area = $miCuadrado->calcularArea();
if ($area !== null) {
    echo "El área del cuadrado es: $area\n";
}

$cuadradoInvalido = new Cuadrado(-3); // Intentar crear un cuadrado con un lado inválido
$areaInvalida = $cuadradoInvalido->calcularArea(); // Verificar comportamiento con valores inválidos
?>

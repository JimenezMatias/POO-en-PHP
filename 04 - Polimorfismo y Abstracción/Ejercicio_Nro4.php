**Ejercicio 4**  
   Define una clase abstracta `Figura` con un método abstracto `area`. Crea subclases `Triangulo` y `Circulo` que implementen `area`. Usa un arreglo para mostrar las áreas.
/
<?php
// Clase base abstracta
abstract class Figura {
    // Método abstracto que debe ser implementado por las subclases
    abstract public function area();
}

// Subclase Triangulo que hereda de Figura
class Triangulo extends Figura {
    private $base;
    private $altura;

    // Constructor para inicializar la base y la altura
    public function __construct($base, $altura) {
        $this->base = $base;
        $this->altura = $altura;
    }

    // Implementación del método abstracto para calcular el área
    public function area() {
        return ($this->base * $this->altura) / 2;
    }
}

// Subclase Circulo que hereda de Figura
class Circulo extends Figura {
    private $radio;

    // Constructor para inicializar el radio
    public function __construct($radio) {
        $this->radio = $radio;
    }

    // Implementación del método abstracto para calcular el área
    public function area() {
        return pi() * pow($this->radio, 2); // Área del círculo: πr²
    }
}

// Crear un arreglo de objetos que implementan Figura
$figuras = [
    new Triangulo(10, 5), // Triángulo con base 10 y altura 5
    new Circulo(7),       // Círculo con radio 7
    new Triangulo(8, 4),  // Triángulo con base 8 y altura 4
    new Circulo(3)        // Círculo con radio 3
];

// Recorrer el arreglo y mostrar las áreas
foreach ($figuras as $figura) {
    echo "Área: " . $figura->area() . "\n";
}
?>

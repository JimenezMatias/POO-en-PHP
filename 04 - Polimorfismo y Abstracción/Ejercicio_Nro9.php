**Ejercicio 9**  
   Crea una interfaz `Calculable` con un método `calcularPerimetro`. Define clases `Cuadrado` y `Circulo` que implementen `calcularPerimetro`. Recorre un arreglo mostrando los perímetros.
/   
<?php
// Definición de la interfaz Calculable
interface Calculable {
    // Método abstracto para calcular el perímetro
    public function calcularPerimetro();
}

// Clase Cuadrado que implementa la interfaz Calculable
class Cuadrado implements Calculable {
    private $lado;

    // Constructor para inicializar el lado del cuadrado
    public function __construct($lado) {
        $this->lado = $lado;
    }

    public function calcularPerimetro() {
        return 4 * $this->lado; // Fórmula para el perímetro del cuadrado
    }
}

// Clase Circulo que implementa la interfaz Calculable
class Circulo implements Calculable {
    private $radio;

    // Constructor para inicializar el radio del círculo
    public function __construct($radio) {
        $this->radio = $radio;
    }

    public function calcularPerimetro() {
        return 2 * pi() * $this->radio; // Fórmula para el perímetro del círculo
    }
}

// Crear un arreglo de objetos que implementan Calculable
$figuras = [
    new Cuadrado(4),   // Cuadrado con lado 4
    new Circulo(3),    // Círculo con radio 3
    new Cuadrado(7),   // Cuadrado con lado 7
    new Circulo(5)     // Círculo con radio 5
];

// Recorrer el arreglo y mostrar los perímetros
foreach ($figuras as $figura) {
    echo "Perímetro: " . $figura->calcularPerimetro() . "\n";
}
?>

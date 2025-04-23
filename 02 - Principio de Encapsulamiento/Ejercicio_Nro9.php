**Ejercicio 9**  
   Crea una clase `Circulo` con una propiedad privada `radio`. Incluye un constructor, un método `getRadio` y un método `setRadio` que valide valores positivos. Prueba con valores válidos e inválidos.
/
<?php
class Circulo {
    // Propiedad privada
    private $radio;

    // Constructor para inicializar el radio
    public function __construct($radioInicial) {
        if ($radioInicial > 0) {
            $this->radio = $radioInicial;
        } else {
            echo "El radio inicial debe ser mayor a 0.\n";
            $this->radio = null; // Inicialización segura
        }
    }

    // Método para obtener el radio
    public function getRadio() {
        return $this->radio;
    }

    // Método para establecer un nuevo radio
    public function setRadio($nuevoRadio) {
        if ($nuevoRadio > 0) {
            $this->radio = $nuevoRadio;
            echo "El radio ha sido actualizado a $nuevoRadio.\n";
        } else {
            echo "El radio debe ser mayor a 0.\n";
        }
    }
}

// Prueba con valores válidos e inválidos
$miCirculo = new Circulo(5); // Crear un objeto con un radio inicial válido
echo "Radio inicial: " . $miCirculo->getRadio() . "\n"; // Consultar el radio inicial

$miCirculo->setRadio(10); // Establecer un nuevo radio válido
$miCirculo->setRadio(-3); // Intentar establecer un radio inválido
echo "Radio final: " . $miCirculo->getRadio() . "\n"; // Consultar el radio final
?>

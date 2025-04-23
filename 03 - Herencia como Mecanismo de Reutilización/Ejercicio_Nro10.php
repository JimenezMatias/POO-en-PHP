**Ejercicio 10**  
    Define una clase base `Animal` con `nombre` y un método `moverse`. Crea una subclase `Pez` que añada `tipoAgua` y sobrescriba `moverse` con un mensaje diferente. Prueba con un objeto.
/
<?php
// Clase base
class Animal {
    // Propiedad de la clase base
    protected $nombre;

    // Constructor para inicializar el nombre
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    // Método de la clase base
    public function moverse() {
        echo "El animal $this->nombre se está moviendo.\n";
    }
}

// Subclase que hereda de Animal
class Pez extends Animal {
    // Propiedad adicional de la subclase
    private $tipoAgua;

    // Constructor para inicializar el nombre y el tipo de agua
    public function __construct($nombre, $tipoAgua) {
        parent::__construct($nombre); // Llamada al constructor de la clase base
        $this->tipoAgua = $tipoAgua;
    }

    // Método sobrescrito
    public function moverse() {
        echo "El pez $this->nombre nada en el agua $this->tipoAgua.\n";
    }
}

// Prueba con un objeto
$animal = new Animal("Tigre"); // Crear un objeto de la clase base
$animal->moverse(); // Llamar al método de la clase base

$pez = new Pez("Dorado", "dulce"); // Crear un objeto de la subclase Pez
$pez->moverse(); // Llamar al método sobrescrito de la subclase
?>

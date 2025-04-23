4: Polimorfismo y Abstracción

**Ejercicio 1**  
   Crea una interfaz `Nadador` con un método `nadar`. Define dos clases, `Pez` y `Persona`, que implementen `nadar` con mensajes distintos. Crea un arreglo de objetos y recorrelo ejecutando `nadar`.
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

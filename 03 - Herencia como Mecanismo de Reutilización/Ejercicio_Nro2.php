**Ejercicio 2**  
   Define una clase base `Animal` con la propiedad `especie` y un método `emitirSonido`. Crea una subclase `Gato` que sobrescriba `emitirSonido` para mostrar "¡Miau!". Instancia y ejecuta el método.
/
<?php
// Clase base
class Animal {
    // Propiedad de la clase base
    protected $especie;

    // Constructor para inicializar la especie
    public function __construct($especie) {
        $this->especie = $especie;
    }

    // Método de la clase base
    public function emitirSonido() {
        echo "El animal de especie $this->especie emite un sonido.\n";
    }
}

// Subclase que hereda de Animal
class Gato extends Animal {
    // Constructor que reutiliza el de la clase base
    public function __construct() {
        parent::__construct("Gato"); // Inicializar la especie como "Gato"
    }

    // Método sobrescrito
    public function emitirSonido() {
        echo "¡Miau!\n";
    }
}

// Prueba con un objeto
$animal = new Animal("Perro"); // Crear un objeto de la clase base
$animal->emitirSonido(); // Ejecutar el método de la clase base

$gato = new Gato(); // Crear un objeto de la subclase Gato
$gato->emitirSonido(); // Ejecutar el método sobres   
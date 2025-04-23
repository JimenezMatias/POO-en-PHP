**Ejercicio 3**  
   Crea una clase base `Persona` con las propiedades `nombre` y `edad`, y un método `saludar`. Define una subclase `Profesor` que añada `materia` y sobrescriba `saludar` incluyendo la materia. Prueba con un objeto.
/
<?php
// Clase base
class Persona {
    // Propiedades de la clase base
    protected $nombre;
    protected $edad;

    // Constructor para inicializar nombre y edad
    public function __construct($nombre, $edad) {
        $this->nombre = $nombre;
        $this->edad = $edad;
    }

    // Método de la clase base
    public function saludar() {
        echo "Hola, soy $this->nombre y tengo $this->edad años.\n";
    }
}

// Subclase que hereda de Persona
class Profesor extends Persona {
    // Propiedad adicional de la subclase
    private $materia;

    // Constructor para inicializar nombre, edad y materia
    public function __construct($nombre, $edad, $materia) {
        parent::__construct($nombre, $edad); // Llamada al constructor de la clase base
        $this->materia = $materia;
    }

    // Método sobrescrito
    public function saludar() {
        echo "Hola, soy $this->nombre, tengo $this->edad años y enseño $this->materia.\n";
    }
}

// Prueba con un objeto
$persona = new Persona("Carlos", 25); // Crear un objeto de la clase base
$persona->saludar(); // Llamada al método de la clase base

$profesor = new Profesor("Ana", 40, "Matemáticas"); // Crear un objeto de la subclase Profesor
$profesor->saludar(); // Llamada al método sobrescrito de la subclase
?>

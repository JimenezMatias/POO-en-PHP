<?php
// Clase base
class Vehiculo {
    // Propiedad de la clase base
    protected $marca;

    // Constructor para inicializar la marca
    public function __construct($marca) {
        $this->marca = $marca;
    }

    // Método de la clase base
    public function avanzar() {
        echo "El vehículo de marca $this->marca está avanzando.\n";
    }
}

// Subclase que hereda de Vehiculo
class Moto extends Vehiculo {
    // Propiedad adicional de la subclase
    private $cilindrada;

    // Constructor para inicializar la marca y la cilindrada
    public function __construct($marca, $cilindrada) {
        parent::__construct($marca); // Llamada al constructor de la clase base
        $this->cilindrada = $cilindrada;
    }

    // Método sobrescrito
    public function avanzar() {
        echo "La moto de marca $this->marca y cilindrada $this->cilindrada cc está avanzando a toda velocidad.\n";
    }
}

// Prueba con un objeto
$miVehiculo = new Vehiculo("Toyota");
$miVehiculo->avanzar(); // Llamada al método de la clase base

$miMoto = new Moto("Yamaha", 150);
$miMoto->avanzar(); // Llamada al método sobrescrito de la subclase
?>

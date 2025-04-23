**Ejercicio 8**  
   Define una clase base `Vehiculo` con `velocidad` y un método `acelerar`. Crea una subclase `Camion` que sobrescriba `acelerar` para aumentar la velocidad en 10 unidades. Prueba con un objeto.
/
<?php
// Clase base
class Vehiculo {
    // Propiedad de la clase base
    protected $velocidad;

    // Constructor para inicializar la velocidad
    public function __construct($velocidadInicial) {
        $this->velocidad = $velocidadInicial;
    }

    // Método de la clase base para acelerar
    public function acelerar() {
        $this->velocidad += 5;
        echo "El vehículo ha acelerado. Velocidad actual: $this->velocidad km/h.\n";
    }
}

// Subclase que hereda de Vehiculo
class Camion extends Vehiculo {
    // Método sobrescrito para aumentar la velocidad en 10 unidades
    public function acelerar() {
        $this->velocidad += 10;
        echo "El camión ha acelerado. Velocidad actual: $this->velocidad km/h.\n";
    }
}

// Prueba con un objeto
$miVehiculo = new Vehiculo(50); // Crear un objeto de la clase base
$miVehiculo->acelerar(); // Llamar al método de la clase base

$miCamion = new Camion(30); // Crear un objeto de la subclase Camion
$miCamion->acelerar(); // Llamar al método sobrescrito de la subclase
?>

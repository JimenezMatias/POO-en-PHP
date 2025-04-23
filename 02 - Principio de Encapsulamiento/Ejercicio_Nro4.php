**Ejercicio 4**  
   Define una clase `Vehiculo` con una propiedad privada `kilometros`. Agrega un constructor, un método `getKilometros` y un método `avanzar` que incremente los kilómetros si el valor es positivo. Crea un objeto y muestra el resultado.
/
   
<?php
class Vehiculo {
    // Propiedad privada
    private $kilometros;

    // Constructor para inicializar los kilómetros
    public function __construct($kilometrosIniciales) {
        if ($kilometrosIniciales >= 0) {
            $this->kilometros = $kilometrosIniciales;
        } else {
            echo "Los kilómetros iniciales no pueden ser negativos.\n";
            $this->kilometros = 0; // Inicialización segura
        }
    }

    // Método para consultar los kilómetros
    public function getKilometros() {
        return $this->kilometros;
    }

    // Método para avanzar, incrementando los kilómetros
    public function avanzar($kilometrosARecorrer) {
        if ($kilometrosARecorrer > 0) {
            $this->kilometros += $kilometrosARecorrer;
            echo "El vehículo ha avanzado $kilometrosARecorrer kilómetros. Total ahora: $this->kilometros kilómetros.\n";
        } else {
            echo "Los kilómetros a recorrer deben ser positivos.\n";
        }
    }
}


$miVehiculo = new Vehiculo(50); // Crear objeto con kilómetros iniciales válidos
echo "Kilómetros iniciales: " . $miVehiculo->getKilometros() . " km\n"; // Consultar kilómetros iniciales

$miVehiculo->avanzar(20); // Avanzar kilómetros válidos
$miVehiculo->avanzar(-5); // Intentar avanzar kilómetros inválidos
echo "Kilómetros finales: " . $miVehiculo->getKilometros() . " km\n"; // Consultar kilómetros finales
?>

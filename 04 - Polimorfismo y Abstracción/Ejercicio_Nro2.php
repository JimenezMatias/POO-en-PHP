**Ejercicio 2**  
   Define una clase abstracta `Vehiculo` con un método abstracto `desplazarse`. Crea subclases `Bicicleta` y `Avion` que implementen `desplazarse`. Usa un arreglo para probar los métodos.
/
<?php
// Clase base abstracta
abstract class Vehiculo {
    // Método abstracto que debe ser implementado por las subclases
    abstract public function desplazarse();
}

// Subclase Bicicleta que hereda de Vehiculo
class Bicicleta extends Vehiculo {
    public function desplazarse() {
        echo "La bicicleta se desplaza pedaleando por la carretera.\n";
    }
}

// Subclase Avion que hereda de Vehiculo
class Avion extends Vehiculo {
    public function desplazarse() {
        echo "El avión se desplaza volando por el cielo.\n";
    }
}

// Crear un arreglo de objetos de diferentes subclases
$vehiculos = [
    new Bicicleta(),
    new Avion(),
    new Bicicleta(),
    new Avion()
];

// Recorrer el arreglo y ejecutar el método desplazarse
foreach ($vehiculos as $vehiculo) {
    $vehiculo->desplazarse();
}
?>

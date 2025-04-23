**Ejercicio 9**
    Define una clase `Trabajador` con las propiedades `nombre`, `cargo` y `salario`. Agrega un método `informacion` que imprima los datos del trabajador. Crea un objeto y usa el método.
/ 

<?php
class Trabajador {
    // Propiedades de la clase
    public $nombre;
    public $cargo;
    public $salario;

    // Método para imprimir la información del trabajador
    public function informacion() {
        echo "Nombre: " . $this->nombre . "\n";
        echo "Cargo: " . $this->cargo . "\n";
        echo "Salario: $" . $this->salario . "\n";
    }
}

// Crear un objeto de la clase Trabajador
$trabajador = new Trabajador();
$trabajador->nombre = "María González";
$trabajador->cargo = "Desarrolladora Web";
$trabajador->salario = 85000;

// Usar el método para mostrar la información del trabajador
$trabajador->informacion();
?>

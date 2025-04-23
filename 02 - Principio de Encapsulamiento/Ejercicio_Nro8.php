**Ejercicio 8**  
   Define una clase `Empleado` con una propiedad privada `sueldo`. Agrega un constructor, un método `getSueldo` y un método `aumentarSueldo` que aplique un incremento porcentual. Instancia y muestra el nuevo sueldo.
/
<?php
class Empleado {
    // Propiedad privada
    private $sueldo;

    // Constructor para inicializar el sueldo
    public function __construct($sueldoInicial) {
        if ($sueldoInicial > 0) {
            $this->sueldo = $sueldoInicial;
        } else {
            echo "El sueldo inicial debe ser mayor a 0.\n";
            $this->sueldo = null; // Inicialización segura
        }
    }

    // Método para obtener el sueldo actual
    public function getSueldo() {
        return $this->sueldo;
    }

    // Método para aumentar el sueldo en un porcentaje
    public function aumentarSueldo($porcentaje) {
        if ($porcentaje > 0) {
            $incremento = ($this->sueldo * $porcentaje) / 100;
            $this->sueldo += $incremento;
            echo "El sueldo ha aumentado en un $porcentaje%. Nuevo sueldo: $$this->sueldo.\n";
        } else {
            echo "El porcentaje de aumento debe ser mayor a 0.\n";
        }
    }
}

// Prueba con un objeto
$empleado = new Empleado(50000); // Crear objeto con un sueldo inicial válido
echo "Sueldo inicial: $" . $empleado->getSueldo() . "\n"; // Consultar sueldo inicial

$empleado->aumentarSueldo(10); // Aumentar el sueldo en un 10%
$empleado->aumentarSueldo(-5); // Intentar un aumento con un porcentaje inválido
echo "Sueldo final: $" . $empleado->getSueldo() . "\n"; // Consultar sueldo final
?>

**Ejercicio 9**  
   Crea una clase base `Empleado` con `nombre` y `salario`, y un método `calcularPago`. Define una subclase `Freelancer` con `horas` y sobrescriba `calcularPago` basado en horas. Instancia y muestra el pago.
/
<?php
// Clase base
class Empleado {
    // Propiedades de la clase base
    protected $nombre;
    protected $salario;

    // Constructor para inicializar nombre y salario
    public function __construct($nombre, $salario) {
        $this->nombre = $nombre;
        $this->salario = $salario;
    }

    // Método para calcular el pago (en la clase base simplemente devuelve el salario)
    public function calcularPago() {
        return $this->salario;
    }
}

// Subclase que hereda de Empleado
class Freelancer extends Empleado {
    // Propiedad adicional para las horas trabajadas
    private $horas;

    // Constructor para inicializar nombre, salario (como tarifa por hora) y horas trabajadas
    public function __construct($nombre, $tarifaPorHora, $horas) {
        parent::__construct($nombre, $tarifaPorHora); // Llamar al constructor de la clase base
        $this->horas = $horas;
    }

    // Método sobrescrito para calcular el pago basado en las horas trabajadas
    public function calcularPago() {
        return $this->salario * $this->horas; // Salario en este caso es la tarifa por hora
    }
}

// Prueba con un objeto
$empleado = new Empleado("Carlos", 2000); // Crear un objeto de la clase base
echo "Empleado: $empleado->nombre, Pago: $" . $empleado->calcularPago() . "\n";

$freelancer = new Freelancer("Ana", 25, 80); // Crear un objeto de la subclase Freelancer
echo "Freelancer: $freelancer->nombre, Pago: $" . $freelancer->calcularPago() . "\n";
?>

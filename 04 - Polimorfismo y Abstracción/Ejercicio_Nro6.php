**Ejercicio 6**  
   Define una clase abstracta `Trabajador` con un método abstracto `calcularIngreso`. Crea subclases `Fijo` y `Temporal` que implementen `calcularIngreso` distinto. Muestra los ingresos en un arreglo.
/
<?php
// Clase abstracta
abstract class Trabajador {
    // Método abstracto que deben implementar las subclases
    abstract public function calcularIngreso();
}

// Subclase Fijo que hereda de Trabajador
class Fijo extends Trabajador {
    private $salarioMensual;

    // Constructor para inicializar el salario mensual
    public function __construct($salarioMensual) {
        $this->salarioMensual = $salarioMensual;
    }

    // Implementación del método abstracto
    public function calcularIngreso() {
        return $this->salarioMensual; // El ingreso fijo es simplemente el salario mensual
    }
}

// Subclase Temporal que hereda de Trabajador
class Temporal extends Trabajador {
    private $tarifaPorHora;
    private $horasTrabajadas;

    // Constructor para inicializar tarifa por hora y horas trabajadas
    public function __construct($tarifaPorHora, $horasTrabajadas) {
        $this->tarifaPorHora = $tarifaPorHora;
        $this->horasTrabajadas = $horasTrabajadas;
    }

    // Implementación del método abstracto
    public function calcularIngreso() {
        return $this->tarifaPor   
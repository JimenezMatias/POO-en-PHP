**Ejercicio 6**  
   Define una clase base `Cuenta` con `saldo` y métodos `depositar` y `retirar`. Crea una subclase `CuentaPremium` que añada `bonificacion` y un método `aplicarBonificacion`. Instancia y muestra el saldo tras aplicar la bonificación.
/
<?php
// Clase base
class Cuenta {
    // Propiedad de la clase base
    protected $saldo;

    // Constructor para inicializar el saldo
    public function __construct($saldoInicial) {
        if ($saldoInicial >= 0) {
            $this->saldo = $saldoInicial;
        } else {
            echo "El saldo inicial debe ser mayor o igual a 0.\n";
            $this->saldo = 0; // Inicialización segura
        }
    }

    // Método para depositar dinero
    public function depositar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
            echo "Has depositado $$monto. Saldo actual: $$this->saldo.\n";
        } else {
            echo "El monto a depositar debe ser mayor a 0.\n";
        }
    }

    // Método para retirar dinero
    public function retirar($monto) {
        if ($monto > 0 && $monto <= $this->saldo) {
            $this->saldo -= $monto;
            echo "Has retirado $$monto. Saldo actual: $$this->saldo.\n";
        } else {
            echo "Fondos insuficientes o monto inválido.\n";
        }
    }
}

// Subclase que hereda de Cuenta
class CuentaPremium extends Cuenta {
    // Propiedad adicional de la subclase
    private $bonificacion;

    // Constructor para inicializar saldo y bonificación
    public function __construct($saldoInicial, $bonificacion) {
        parent::__construct($saldoInicial); // Llamada al constructor de la clase base
        if ($bonificacion >= 0) {
            $this->bonificacion = $bonificacion;
        } else {
            echo "La bonificación debe ser mayor o igual a 0.\n";
            $this->bonificacion = 0; // Inicialización segura
        }
    }

    // Método para aplicar la bonificación
    public function aplicarBonificacion() {
        $this->saldo += $this->bonificacion;
        echo "Se ha aplicado una bonificación de $$this->bonificacion. Saldo actual: $$this->saldo.\n";
    }
}

// Prueba con un objeto
$miCuentaPremium = new CuentaPremium(1000, 200); // Crear una cuenta premium con saldo inicial y bonificación
$miCuentaPremium->depositar(500); // Depositar dinero
$miCuentaPremium->retirar(300); // Retirar dinero
$miCuentaPremium->aplicarBonificacion(); // Aplicar la bonificación
echo "Saldo final: $" . $miCuentaPremium->saldo . "\n"; // Mostrar saldo final
?>

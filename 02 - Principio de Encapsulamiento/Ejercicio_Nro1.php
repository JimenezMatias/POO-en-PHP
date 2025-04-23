**Ejercicio 1**  
   Crea una clase `CuentaBancaria` con una propiedad privada `saldo`. Incluye un constructor para inicializar el saldo, un método `getSaldo` para consultarlo y un método `depositar` que sume un monto positivo. Prueba con un objeto.
/   
<?php
class CuentaBancaria {
    // Propiedad privada
    private $saldo;

    // Constructor para inicializar el saldo
    public function __construct($saldoInicial) {
        $this->saldo = $saldoInicial;
    }

    // Método para consultar el saldo
    public function getSaldo() {
        return $this->saldo;
    }

    // Método para depositar un monto positivo
    public function depositar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
            echo "Has depositado $$monto. Nuevo saldo: $$this->saldo\n";
        } else {
            echo "El monto debe ser positivo.\n";
        }
    }
}

// Prueba con un objeto
$miCuenta = new CuentaBancaria(100); // Saldo inicial
echo "Saldo inicial: $" . $miCuenta->getSaldo() . "\n"; // Consultar saldo

$miCuenta->depositar(50); 
$miCuenta->depositar(-20); 
echo "Saldo final: $" . $miCuenta->getSaldo() . "\n"; // Consultar saldo final
?>

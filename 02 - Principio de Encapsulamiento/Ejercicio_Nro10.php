**Ejercicio 10**  
    Define una clase `CuentaCorriente` con propiedades privadas `saldo` y `limite`. Agrega un constructor, un método `getSaldo` y un método `retirar` que permita retiros solo si el saldo más el límite lo cubren. Prueba con un objeto.
/
<?php
class CuentaCorriente {
    // Propiedades privadas
    private $saldo;
    private $limite;

    // Constructor para inicializar el saldo y el límite
    public function __construct($saldoInicial, $limiteInicial) {
        if ($saldoInicial >= 0 && $limiteInicial >= 0) {
            $this->saldo = $saldoInicial;
            $this->limite = $limiteInicial;
        } else {
            echo "El saldo y el límite deben ser mayores o iguales a 0.\n";
            $this->saldo = 0; // Inicialización segura
            $this->limite = 0; // Inicialización segura
        }
    }

    // Método para obtener el saldo actual
    public function getSaldo() {
        return $this->saldo;
    }

    // Método para retirar dinero
    public function retirar($monto) {
        if ($monto > 0) {
            if (($this->saldo + $this->limite) >= $monto) {
                $this->saldo -= $monto;
                echo "Has retirado $$monto. Nuevo saldo: $$this->saldo.\n";
            } else {
                echo "Fondos insuficientes. El saldo más el límite no cubre el monto.\n";
            }
        } else {
            echo "El monto debe ser mayor a 0.\n";
        }
    }
}

// Prueba con un objeto
$miCuenta = new CuentaCorriente(500, 200); // Crear objeto con saldo inicial y límite válidos
echo "Saldo inicial: $" . $miCuenta->getSaldo() . "\n"; // Consultar saldo inicial

$miCuenta->retirar(400); // Intentar retirar un monto válido
$miCuenta->retirar(350); // Intentar retirar un monto que excede el saldo más el límite
$miCuenta->retirar(-50); // Intentar retirar un monto inválido
echo "Saldo final: $" . $miCuenta->getSaldo() . "\n"; // Consultar saldo final
?>

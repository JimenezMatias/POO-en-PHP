**Ejercicio 6**  
   Crea una clase `Cuenta` con la propiedad `saldo`. Agrega métodos `ingresar` (suma un monto al saldo) y `retirar` (resta un monto del saldo). Instancia un objeto, realiza operaciones y muestra el saldo final.
/
<?php
class Cuenta {
    // Propiedad de la clase
    public $saldo;

    // Método para ingresar un monto al saldo
    public function ingresar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
        } else {
            echo "El monto debe ser positivo.\n";
        }
    }

    // Método para retirar un monto del saldo
    public function retirar($monto) {
        if ($monto > 0) {
            if ($monto <= $this->saldo) {
                $this->saldo -= $monto;
            } else {
                echo "Fondos insuficientes.\n";
            }
        } else {
            echo "El monto debe ser positivo.\n";
        }
    }

    // Método para mostrar el saldo actual
    public function mostrarSaldo() {
        return $this->saldo;
    }
}

// Crear una instancia de la clase Cuenta 
$cuenta = new Cuenta();
$cuenta->saldo = 1000; // Inicializar el saldo 


$cuenta->ingresar(500); // Ingresar 500
$cuenta->retirar(300);  // Retirar 300
$cuenta->retirar(1500); // Intentar retirar más de lo disponible

// Mostrar el saldo final
echo "El saldo final es: " . $cuenta->mostrarSaldo();
?>


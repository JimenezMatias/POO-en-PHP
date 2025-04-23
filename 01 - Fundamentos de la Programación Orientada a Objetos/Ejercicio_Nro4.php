**Ejercicio 4**  
   Crea una clase `Coche` con las propiedades `marca`, `modelo` y `color`. Agrega un método `detalles` que muestre un mensaje con la información del coche. Crea un objeto y ejecuta el método.
/
<?php
class Coche {
    public $marca;
    public $modelo;
    public $color;

    public function detalles() {
        echo "Marca: $this->marca<br>";
        echo "Modelo: $this->modelo<br>";
        echo "Color: $this->color<br>";
    }
}

$carro = new Coche();
$carro->marca = "Toyota";
$carro->modelo = "Corolla";
$carro->color = "Negro";

$carro->detalles();
?>

**Ejercicio 2**  
   Crea una clase `Rectangulo` con las propiedades `largo` y `ancho`. Agrega un método `calcularArea` que retorne el área del rectángulo (`largo * ancho`). Crea un objeto, asigna valores y muestra el resultado del área.
/
<?php
class Rectangulo {
    public $largo;
    public $ancho;

    public function calcularArea() {
        return $this->largo * $this->ancho;
    }
}

$rect = new Rectangulo();
$rect->largo = 5;
$rect->ancho = 3;

echo "Área del rectángulo: " . $rect->calcularArea();
?>

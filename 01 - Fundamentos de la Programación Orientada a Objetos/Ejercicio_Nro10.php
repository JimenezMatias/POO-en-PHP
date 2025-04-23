**Ejercicio 10**  
    Crea una clase `Triangulo` con las propiedades `base` y `altura`. Añade un método `area` que calcule el área (`base * altura / 2`). Instancia un objeto y muestra el área.
/

<?php
class Triangulo {
    // Propiedades 
    public $base;
    public $altura;

    // Método para calcular el área
    public function area() {
        return ($this->base * $this->altura) / 2;
    }
}

// Crear un objeto de la clase Triangulo
$triangulo = new Triangulo();
$triangulo->base = 10;   
$triangulo->altura = 5; 

// Mostrar el área del triángulo
echo "El área del triángulo con base " . $triangulo->base . " y altura " . $triangulo->altura . " es: " . $triangulo->area();
?>

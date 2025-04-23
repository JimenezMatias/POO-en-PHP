**Ejercicio 8**  
   Crea una clase `Circulo` con la propiedad `radio`. Incluye un método `calcularPerimetro` que retorne el perímetro (`2 * π * radio`). Instancia un objeto y muestra el perímetro.
/

<?php
class Circulo {
    // Propiedad de la clase
    public $radio;

    // Método 
    public function calcularPerimetro() {
        return 2 * pi() * $this->radio; // 
    }
}

// Crear un objeto de la clase Circulo
$circulo = new Circulo();
$circulo->radio = 5; // Asignar un valor al radio

// Mostrar el perímetro del círculo
echo "El perímetro del círculo con radio " . $circulo->radio . " es: " . $circulo->calcularPerimetro();
?>

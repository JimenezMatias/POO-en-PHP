**Ejercicio 5**  
   Define una clase `Persona` con las propiedades `nombre` y `edad`. Incluye un método `esAdulto` que retorne `true` si la edad es mayor o igual a 18, y `false` en caso contrario. Prueba el método con un objeto.
/
<?php
class Persona {
    // Propiedades de la clase
    public $nombre;
    public $edad;

    // Método para determinar si es adulto
    public function esAdulto() {
        return $this->edad >= 18; // Retorna true o false directamente
    }
}

// Crear un objeto de la clase Persona 
$persona = new Persona();
$persona->nombre = "Juan";
$persona->edad = 16;


echo $persona->esAdulto() ? "true" : "false";

// imprimirá "false" porque Juan tiene 16 años
?>

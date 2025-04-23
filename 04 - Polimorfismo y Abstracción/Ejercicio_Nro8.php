**Ejercicio 8**  
   Define una clase abstracta `Instrumento` con un método abstracto `tocar`. Crea subclases `Violin` y `Bateria` que implementen `tocar`. Usa un arreglo para probar los métodos.
/
<?php
// Clase base abstracta
abstract class Instrumento {
    // Método abstracto que debe ser implementado por las subclases
    abstract public function tocar();
}

// Subclase Violin que hereda de Instrumento
class Violin extends Instrumento {
    public function tocar() {
        echo "El violín está tocando una melodía suave.\n";
    }
}

// Subclase Bateria que hereda de Instrumento
class Bateria extends Instrumento {
    public function tocar() {
        echo "La batería está tocando un ritmo energético.\n";
    }
}

// Crear un arreglo de objetos que implementen Instrumento
$instrumentos = [
    new Violin(),  // Instancia de la subclase Violin
    new Bateria(), // Instancia de la subclase Bateria
    new Violin(),  // Otra instancia de Violin
    new Bateria()  // Otra instancia de Bateria
];

// Recorrer el arreglo y ejecutar el método tocar
foreach ($instrumentos as $instrumento) {
    $instrumento->tocar();
}
?>

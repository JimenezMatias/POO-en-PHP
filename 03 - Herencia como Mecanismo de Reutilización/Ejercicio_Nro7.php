**Ejercicio 7**  
   Crea una clase base `Instrumento` con un método abstracto `sonar`. Define una subclase `Piano` que implemente `sonar` con un mensaje específico. Instancia y ejecuta el método.
/
<?php
// Clase base abstracta
abstract class Instrumento {
    // Método abstracto que debe ser implementado por las subclases
    abstract public function sonar();
}

// Subclase que hereda de Instrumento
class Piano extends Instrumento {
    // Implementación del método abstracto
    public function sonar() {
        echo "El piano está sonando: ¡Plin-plin-plin!\n";
    }
}

// Prueba con un objeto
$miPiano = new Piano(); // Crear un objeto de la subclase Piano
$miPiano->sonar(); // Llamar al método implementado
?>

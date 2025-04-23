**Ejercicio 10**  
    Define una clase abstracta `Animal` con un método abstracto `alimentarse`. Crea subclases `Leon` y `Pajaro` que implementen `alimentarse`. Usa un arreglo para ejecutar los métodos.
/
<?php
// Clase base abstracta
abstract class Animal {
    // Método abstracto que las subclases deben implementar
    abstract public function alimentarse();
}

// Subclase Leon que hereda de Animal
class Leon extends Animal {
    public function alimentarse() {
        echo "El león se alimenta de carne.\n";
    }
}

// Subclase Pajaro que hereda de Animal
class Pajaro extends Animal {
    public function alimentarse() {
        echo "El pájaro se alimenta de semillas.\n";
    }
}

// Crear un arreglo de objetos que implementan Animal
$animales = [
    new Leon(),  // Instancia de la subclase Leon
    new Pajaro(), // Instancia de la subclase Pajaro
    new Leon(),  // Otra instancia de Leon
    new Pajaro()  // Otra instancia de Pajaro
];

// Recorrer el arreglo y ejecutar el método alimentarse
foreach ($animales as $animal) {
    $animal->alimentarse();
}
?>

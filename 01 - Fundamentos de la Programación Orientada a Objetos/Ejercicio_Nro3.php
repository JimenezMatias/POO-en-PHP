**Ejercicio 3**  
   Define una clase `Estudiante` con las propiedades `nombre`, `edad` y `matricula`. Añade un método `mostrarDatos` que imprima los datos del estudiante. Instancia un objeto y usa el método.
/
<?php
class Estudiante {
    public $nombre;
    public $edad;
    public $matricula;

    public function mostrarDatos() {
        echo "Nombre: $this->nombre<br>";
        echo "Edad: $this->edad<br>";
        echo "Matrícula: $this->matricula<br>";
    }
}

$estu = new Estudiante();
$estu->nombre = "Juan";
$estu->edad = 22;
$estu->matricula = "12345";

$estu->mostrarDatos();
?>

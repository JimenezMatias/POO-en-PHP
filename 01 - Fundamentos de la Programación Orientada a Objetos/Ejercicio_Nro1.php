**Ejercicio 1**  
   Crea una clase llamada `Libro` con las propiedades `titulo` y `autor`. Instancia un objeto de esta clase, asigna valores a sus propiedades y muestra el título y el autor en pantalla.
/
<?php 
class Libro {
    public $titulo;
    public $autor;
}

$libro = new Libro()
$libro->titulo = "Harry Potter";
$libro->autor = "J.K.Rowling";

echo "Título: " . $libro->titulo . "<br>";
echo "Autor: " . $libro->autor;
?>
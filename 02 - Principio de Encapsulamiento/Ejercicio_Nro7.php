**Ejercicio 7**  
   Crea una clase `Libro` con una propiedad privada `numeroPaginas`. Incluye un constructor, un método `getPaginas` y un método `setPaginas` que solo acepte valores mayores a 0. Prueba con un objeto.
/
<?php
class Libro {
    // Propiedad privada
    private $numeroPaginas;

    // Constructor para inicializar el número de páginas
    public function __construct($paginasIniciales) {
        if ($paginasIniciales > 0) {
            $this->numeroPaginas = $paginasIniciales;
        } else {
            echo "El número inicial de páginas debe ser mayor a 0.\n";
            $this->numeroPaginas = null; // Inicialización segura
        }
    }

    // Método para obtener el número de páginas
    public function getPaginas() {
        return $this->numeroPaginas;
    }

    // Método para establecer un nuevo número de páginas
    public function setPaginas($nuevasPaginas) {
        if ($nuevasPaginas > 0) {
            $this->numeroPaginas = $nuevasPaginas;
            echo "El número de páginas ha sido actualizado a $nuevasPaginas páginas.\n";
        } else {
            echo "El número de páginas debe ser mayor a 0.\n";
        }
    }
}

// Prueba con un objeto
$miLibro = new Libro(100); // Crear un objeto con un número inicial válido de páginas
echo "Número inicial de páginas: " . $miLibro->getPaginas() . "\n"; // Consultar el número inicial de páginas

$miLibro->setPaginas(200); // Establecer un nuevo número válido de páginas
$miLibro->setPaginas(-50); // Intentar establecer un número inválido de páginas
echo "Número final de páginas: " . $miLibro->getPaginas() . "\n"; // Consultar el número final de páginas
?>

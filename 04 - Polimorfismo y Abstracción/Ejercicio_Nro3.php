**Ejercicio 3**  
   Crea una interfaz `Printable` con un método `imprimir`. Define clases `Documento` y `Foto` que implementen `imprimir` de forma diferente. Recorre un arreglo de objetos ejecutando el método.
/
<?php
// Definición de la interfaz Printable
interface Printable {
    // Método abstracto que las clases deben implementar
    public function imprimir();
}

// Clase Documento que implementa Printable
class Documento implements Printable {
    private $titulo;

    public function __construct($titulo) {
        $this->titulo = $titulo;
    }

    public function imprimir() {
        echo "Imprimiendo el documento: $this->titulo.\n";
    }
}

// Clase Foto que implementa Printable
class Foto implements Printable {
    private $nombre;

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function imprimir() {
        echo "Imprimiendo la foto: $this->nombre.\n";
    }
}

// Crear un arreglo de objetos que implementen Printable
$elementos = [
    new Documento("Contrato de Arrendamiento"),
    new Foto("Vacaciones en la Playa"),
    new Documento("Informe Financiero"),
    new Foto("Retrato Familiar")
];

// Recorrer el arreglo y ejecutar el método imprimir
foreach ($elementos as $elemento) {
    $elemento->imprimir();
}
?>

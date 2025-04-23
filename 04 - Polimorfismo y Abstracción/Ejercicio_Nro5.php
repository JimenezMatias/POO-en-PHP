**Ejercicio 5**  
   Crea una interfaz `Reproducible` con un método `reproducir`. Define clases `Pelicula` y `Podcast` que implementen `reproducir`. Recorre un arreglo ejecutando el método.
/
<?php
// Definición de la interfaz Reproducible
interface Reproducible {
    // Método abstracto que las clases deben implementar
    public function reproducir();
}

// Clase Pelicula que implementa la interfaz Reproducible
class Pelicula implements Reproducible {
    private $titulo;

    public function __construct($titulo) {
        $this->titulo = $titulo;
    }

    public function reproducir() {
        echo "Reproduciendo la película: $this->titulo.\n";
    }
}

// Clase Podcast que implementa la interfaz Reproducible
class Podcast implements Reproducible {
    private $episodio;

    public function __construct($episodio) {
        $this->episodio = $episodio;
    }

    public function reproducir() {
        echo "Reproduciendo el podcast: Episodio $this->episodio.\n";
    }
}

// Crear un arreglo de objetos que implementan Reproducible
$elementos = [
    new Pelicula("Inception"),
    new Podcast("Cómo aprender programación"),
    new Pelicula("Interstellar"),
    new Podcast("Historia del Imperio Romano")
];

// Recorrer el arreglo y ejecutar el método reproducir
foreach ($elementos as $elemento) {
    $elemento->reproducir();
}
?>

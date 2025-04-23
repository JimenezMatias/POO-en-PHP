**Ejercicio 6**  
   Define una clase `Rectangulo` con propiedades privadas `largo` y `ancho`. Agrega un constructor, métodos `getLargo` y `getAncho`, y un método `setDimensiones` que valide valores positivos. Instancia y verifica.
/
<?php
class Rectangulo {
    // Propiedades privadas
    private $largo;
    private $ancho;

    // Constructor para inicializar largo y ancho
    public function __construct($largoInicial, $anchoInicial) {
        if ($largoInicial > 0 && $anchoInicial > 0) {
            $this->largo = $largoInicial;
            $this->ancho = $anchoInicial;
        } else {
            echo "Ambas dimensiones deben ser positivas.\n";
            $this->largo = null; // Inicialización segura
            $this->ancho = null; // Inicialización segura
        }
    }

    // Método para obtener el largo
    public function getLargo() {
        return $this->largo;
    }

    // Método para obtener el ancho
    public function getAncho() {
        return $this->ancho;
    }

    // Método para establecer nuevas dimensiones
    public function setDimensiones($nuevoLargo, $nuevoAncho) {
        if ($nuevoLargo > 0 && $nuevoAncho > 0) {
            $this->largo = $nuevoLargo;
            $this->ancho = $nuevoAncho;
            echo "Las dimensiones se han actualizado: Largo = $nuevoLargo, Ancho = $nuevoAncho.\n";
        } else {
            echo "Ambas dimensiones deben ser positivas.\n";
        }
    }
}


$miRectangulo = new Rectangulo(10, 5); // Crear objeto con dimensiones válidas
echo "Largo inicial: " . $miRectangulo->getLargo() . " cm\n"; // Consultar largo inicial
echo "Ancho inicial: " . $miRectangulo->getAncho() . " cm\n"; // Consultar ancho inicial

$miRectangulo->setDimensiones(15, 8); // Establecer dimensiones válidas
$miRectangulo->setDimensiones(-5, 12); // Intentar establecer dimensiones inválidas

echo "Largo final: " . $miRectangulo->getLargo() . " cm\n"; // Consultar largo final
echo "Ancho final: " . $miRectangulo->getAncho() . " cm\n"; // Consultar ancho final
?>

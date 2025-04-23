**Ejercicio 5**  
   Crea una clase base `Producto` con `nombre` y `precio`, y un método `detalle`. Define una subclase `ProductoOferta` que añada `descuento` y sobrescriba `detalle` con el descuento. Prueba con un objeto.
/
<?php
// Clase base
class Producto {
    // Propiedades de la clase base
    protected $nombre;
    protected $precio;

    // Constructor para inicializar nombre y precio
    public function __construct($nombre, $precio) {
        $this->nombre = $nombre;
        $this->precio = $precio;
    }

    // Método de la clase base para mostrar el detalle
    public function detalle() {
        echo "Producto: $this->nombre, Precio: $$this->precio.\n";
    }
}

// Subclase que hereda de Producto
class ProductoOferta extends Producto {
    // Propiedad adicional de la subclase
    private $descuento;

    // Constructor para inicializar nombre, precio y descuento
    public function __construct($nombre, $precio, $descuento) {
        parent::__construct($nombre, $precio); // Llamada al constructor de la clase base
        $this->descuento = $descuento;
    }

    // Método sobrescrito para mostrar el detalle con el descuento
    public function detalle() {
        $precioConDescuento = $this->precio - ($this->precio * $this->descuento / 100);
        echo "Producto: $this->nombre, Precio original: $$this->precio, Descuento: $this->descuento%, Precio con descuento: $$precioConDescuento.\n";
    }
}

// Prueba con un objeto
$producto = new Producto("Laptop", 1000); // Crear un objeto de la clase base
$producto->detalle(); // Llamada al método de la clase base

$productoOferta = new ProductoOferta("Laptop", 1000, 20); // Crear un objeto de la subclase ProductoOferta
$productoOferta->detalle(); // Llamada al método sobrescrito de la subclase
?>

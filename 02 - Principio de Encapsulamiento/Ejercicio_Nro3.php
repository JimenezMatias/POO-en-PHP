**Ejercicio 3**  
   Crea una clase `Producto` con una propiedad privada `precio`. Incluye un constructor, un método `getPrecio` y un método `setPrecio` que valide que el precio sea positivo. Prueba con valores válidos e inválidos.
/
<?php
class Producto {
    // Propiedad privada
    private $precio;

    // Constructor para inicializar el precio
    public function __construct($precioInicial) {
        if ($precioInicial > 0) {
            $this->precio = $precioInicial;
        } else {
            echo "El precio inicial debe ser positivo.\n";
            $this->precio = null; // Inicialización segura
        }
    }

    // Método para obtener el precio
    public function getPrecio() {
        return $this->precio;
    }

    // Método para asignar un nuevo precio
    public function setPrecio($nuevoPrecio) {
        if ($nuevoPrecio > 0) {
            $this->precio = $nuevoPrecio;
            echo "El precio ha sido actualizado a $$nuevoPrecio.\n";
        } else {
            echo "El precio debe ser positivo.\n";
        }
    }
}


$producto = new Producto(100); // Crear objeto con precio inicial válido
echo "Precio inicial: $" . $producto->getPrecio() . "\n"; // Consultar precio

$producto->setPrecio(200); // Asignar un precio válido
$producto->setPrecio(-50); // Intentar asignar un precio inválido
echo "Precio final: $" . $producto->getPrecio() . "\n"; // Consultar precio final
?>

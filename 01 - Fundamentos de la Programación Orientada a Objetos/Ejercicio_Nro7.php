**Ejercicio 7** 
    Define una clase `Producto` con las propiedades `nombre`, `precio` y `stock`. Añade un método `valorInventario` que calcule el valor total (`precio * stock`). Crea un objeto y muestra el resultado.
/

<?php
class Producto {
    // Propiedades de la clase
    public $nombre;
    public $precio;
    public $stock;

    // Método 
    public function valorInventario() {
        return $this->precio * $this->stock;
    }
}

// Crear un objeto de la clase Producto
$producto = new Producto();
$producto->nombre = "PC";
$producto->precio = 1200; // Precio de cada producto
$producto->stock = 10;    // Cantidad de productos en inventario

echo "El valor total del inventario de " . $producto->nombre . " es: $" . $producto->valorInventario();
?>

<?php
require 'conexion.php';

// Parámetro a buscar 
$nombreBuscado = 'Producto 2';

try {
    $sql = "SELECT * FROM productos WHERE nombre = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => $nombreBuscado]);
    $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($producto) {
        echo "<h2>Resultado de la búsqueda:</h2>";
        foreach ($producto as $item) {
            echo "ID: {$item['id']} - Nombre: {$item['nombre']} - Precio: {$item['precio']}<br>";
        }
    } else {
        echo "No se encontró ningún producto con el nombre '$nombreBuscado'.";
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit('Error al buscar el producto.');
}
?>

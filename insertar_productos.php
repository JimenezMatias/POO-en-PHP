<?php
require 'conexion.php';

// Insertar varios productos
$productos = [
    ['nombre' => 'Producto 1', 'precio' => 10.00],
    ['nombre' => 'Producto 2', 'precio' => 20.00],
    ['nombre' => 'Producto 3', 'precio' => 30.00],
];

$sql = "INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)";
$stmt = $pdo->prepare($sql);

foreach ($productos as $producto) {
    $stmt->execute([
        ':nombre' => $producto['nombre'],
        ':precio' => $producto['precio']
    ]);
}

echo 'Productos insertados correctamente!';
?>

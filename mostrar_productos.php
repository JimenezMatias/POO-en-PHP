<?php
require 'conexion.php';

try {
	$stmt = $pdo-> query("SELECT * FROM productos ORDER BY id DESC");
	$productos = $stmt-> fetchAll(PDO::FETCH_ASSOC);
	echo "<h1> Lista de Productos</h2>";
	echo "<ul>";
	foreach ($productos as $producto) {
		echo "<li> ID: {$producto['id']} - Nombre: {$producto ['nombre']} - Precio: {$producto['precio']}</li>";
	}
	echo "</ul>";
} catch (PDOException $e) {
	error_log($e->getMessage());
	exit('error al obtener los productos');

}

?>

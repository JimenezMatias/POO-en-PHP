<?php
require 'conexion.php';

//Variables simuladas
$nuevoEstado = 'activo';
$idUsuario = 2;

try {
	$sql = "UPDATE usuarios SET estado = :estado WHERE id = :id";
	$stmt = $pdo->prepare($sql);

	$stmt->execute([
	':estado' => $nuevoEstado,
	':id' => $idUsuario
	]);
	
	echo "Estado actualizado correctamente para el usuario con ID $idUsuario.";
}catch (PDOException $e) {
	error_log($e->getMessage());
	exit('error al actualizar el estado del usuario');
}


?>

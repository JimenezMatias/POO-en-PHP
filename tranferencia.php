<?php
require 'conexion.php';

$cuentaOrigen = 1;
$cuentaDestino = 2;
//Para simular el rollback (error) cambiar la variable cuentaDestino e igualarla a 999 por ejemplo.
$monto = 200.00;

try {
	$pdo->beginTransaction();

	//Restar monto a cuenta origen
	$sql = "UPDATE cuentas SET saldo = saldo - :monto WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
	':monto' => $monto,
	':id' => $cuentaOrigen
	]);


	//Sumar monto a cuenta destino
	$sql = "UPDATE cuentas SET saldo = saldo + :monto WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
	':monto' => $monto,
	':id' => $cuentaDestino
	]);

	//Verificamos que la cuenta destino exista
	if($stmt->rowCount() === 0) {
	throw new Exception("La cuenta Destino no existe.");
	}

	$pdo->commit();
	echo "Tranferencia realizada con exito.";
} catch (Exception $e) {
	$pdo->rollBack();
	echo "Error en la transferencia: " . $e->getMessage();
}
?>

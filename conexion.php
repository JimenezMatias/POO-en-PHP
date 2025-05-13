<?php
$host = 'localhost';
$db = 'programacionSeba';
$user = 'estudiante';
$pass = '1234';
$port = '3306';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
	PDO::ATTR_ERRMODE	=>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];
try {
	$pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
	error_log($e->getMessage());
	exit('error al conectarse a la base de datos');
}

?>

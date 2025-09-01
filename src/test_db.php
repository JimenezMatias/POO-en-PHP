<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;

try {
    $db = new Database();
    $pdo = $db->getConnection();
    echo "Conexión exitosa a la base de datos.";
} catch (Exception $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}


?>
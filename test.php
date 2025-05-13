<?php 
$host = '192.168.1.6';      // o la IP de tu máquina si lo ves desde otro dispositivo
$dbname = 'instituto'; // reemplazá por el nombre real de tu base
$user = 'root';           // o el usuario que estés usando
$pass = 'jimenez3770';               // tu contraseña si tiene, o dejalo vacío si no configuraste una

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "holaaaaaaaaaaa";
} catch (PDOException $e) {
    echo "❌ Error al conectar: " . $e->getMessage();
}


?>
<?php
// Script de prueba para verificar las rutas de consulta de ventas
require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Modelos\ConsultaVentasRepository;

try {
    $db = new Database();
    $repo = new ConsultaVentasRepository($db->getConnection());
    
    echo "✅ Conexión a la base de datos exitosa\n";
    
    // Probar SPU de todas las ventas
    echo "🔍 Probando spu_ventas_todas()...\n";
    $ventas = $repo->consultarTodasVentas();
    echo "✅ SPU funcionando. Ventas encontradas: " . count($ventas) . "\n";
    
    // Probar SPU de resumen
    echo "🔍 Probando spu_ventas_fp_todas()...\n";
    $resumen = $repo->resumenTodasFormasPago();
    echo "✅ SPU funcionando. Formas de pago: " . count($resumen) . "\n";
    
    echo "\n🎉 Todos los SPUs están funcionando correctamente!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

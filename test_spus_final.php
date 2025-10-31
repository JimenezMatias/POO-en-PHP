<?php
// Script de prueba para verificar las rutas de consulta de ventas
require __DIR__ . '/vendor/autoload.php';

use App\Config\Database;
use App\Modelos\ConsultaVentasRepository;

try {
    $db = new Database();
    $repo = new ConsultaVentasRepository($db->getConnection());
    
    echo "✅ Conexión a la base de datos exitosa\n";
    
    // Probar SPU de ventas por fecha
    echo "🔍 Probando spu_ventas_fecha()...\n";
    $ventas = $repo->consultarVentas('2025-01-01', '2025-01-31');
    echo "✅ SPU funcionando. Ventas encontradas: " . count($ventas) . "\n";
    
    // Probar SPU de resumen por fecha
    echo "🔍 Probando spu_ventas_fp_fecha()...\n";
    $resumen = $repo->resumenFormasPago('2025-01-01', '2025-01-31');
    echo "✅ SPU funcionando. Formas de pago: " . count($resumen) . "\n";
    
    // Probar SPU de todas las ventas
    echo "🔍 Probando spu_ventas_todas()...\n";
    $todasVentas = $repo->consultarTodasVentas();
    echo "✅ SPU funcionando. Total ventas: " . count($todasVentas) . "\n";
    
    echo "\n🎉 Todos los SPUs están funcionando correctamente!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

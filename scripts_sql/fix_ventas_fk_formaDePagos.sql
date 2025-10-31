-- =====================================================
-- CORREGIR FOREIGN KEY DE VENTAS
-- Cambiar de tipos_ventas a formaDePagos
-- =====================================================

-- Paso 1: Eliminar la foreign key vieja que apunta a tipos_ventas
ALTER TABLE ventas
DROP FOREIGN KEY ventas_ibfk_3;

-- Paso 2: Crear la foreign key nueva que apunta a formaDePagos
ALTER TABLE ventas
ADD CONSTRAINT fk_ventas_formaDePago 
FOREIGN KEY (id_tipo_venta) REFERENCES formaDePagos(id_formaDePago)
ON DELETE RESTRICT
ON UPDATE CASCADE;

-- Paso 3: Verificar que la FK se creó correctamente
SHOW CREATE TABLE ventas;

-- =====================================================
-- Nota: Si tienes ventas existentes con id_tipo_venta 
-- que no existen en formaDePagos, primero debes 
-- actualizarlas o eliminarlas
-- =====================================================

-- Ver si hay ventas con id_tipo_venta que no existen en formaDePagos
SELECT DISTINCT v.id_tipo_venta, COUNT(*) as cantidad
FROM ventas v
LEFT JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
WHERE fp.id_formaDePago IS NULL
GROUP BY v.id_tipo_venta;

-- Si aparecen resultados, ejecuta esto para actualizarlas a "Efectivo" (id=1):
-- UPDATE ventas 
-- SET id_tipo_venta = 1 
-- WHERE id_tipo_venta NOT IN (SELECT id_formaDePago FROM formaDePagos);

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================


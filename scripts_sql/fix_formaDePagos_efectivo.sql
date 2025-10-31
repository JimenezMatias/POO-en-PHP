-- =====================================================
-- CORREGIR TABLA formaDePagos - Asegurar que id=1 sea Efectivo
-- =====================================================

-- Actualizar el registro con id=1 para que sea "Efectivo"
UPDATE formaDePagos 
SET nombre = 'Efectivo' 
WHERE id_formaDePago = 1;

-- Si no existe el registro con id=1, insertarlo
INSERT IGNORE INTO formaDePagos (id_formaDePago, nombre)
VALUES (1, 'Efectivo');

-- Ver el contenido de la tabla
SELECT * FROM formaDePagos ORDER BY id_formaDePago;

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================


-- =====================================================
-- CORREGIR SPU FINALIZAR VENTA
-- Usar suma EXACTA del detalle para evitar diferencias
-- =====================================================

DROP PROCEDURE IF EXISTS spu_finalizarVenta;

DELIMITER $$

CREATE PROCEDURE spu_finalizarVenta(
    IN p_id_venta INT
)
BEGIN
    DECLARE v_importe_total DECIMAL(18,2);
    DECLARE v_ganancia_total DECIMAL(18,2);
    
    -- Calcular totales EXACTOS desde detalle_venta
    SELECT 
        SUM(dv.importe_r),
        SUM(dv.ganancia_r)
    INTO 
        v_importe_total,
        v_ganancia_total
    FROM detalle_venta dv
    WHERE dv.id_venta = p_id_venta;
    
    -- Actualizar la tabla ventas con los totales exactos
    UPDATE ventas
    SET 
        importe = COALESCE(v_importe_total, 0),
        ganancia_t = COALESCE(v_ganancia_total, 0)
    WHERE id_venta = p_id_venta;
    
    -- Actualizar el stock de los productos (descontar)
    UPDATE productos p
    INNER JOIN detalle_venta dv ON p.codigo = dv.codigo
    SET p.stock = p.stock - dv.cant
    WHERE dv.id_venta = p_id_venta;
    
    -- Devolver confirmación con los totales finales
    SELECT 
        'Venta finalizada correctamente' AS mensaje,
        v_importe_total AS importe_final,
        v_ganancia_total AS ganancia_final,
        p_id_venta AS id_venta;
END $$

DELIMITER ;

-- =====================================================
-- ACTUALIZAR VENTA 28 CON TOTALES CORRECTOS
-- =====================================================

-- Calcular y actualizar la venta 28
UPDATE ventas v
SET 
    importe = (SELECT SUM(dv.importe_r) FROM detalle_venta dv WHERE dv.id_venta = 28),
    ganancia_t = (SELECT SUM(dv.ganancia_r) FROM detalle_venta dv WHERE dv.id_venta = 28)
WHERE v.id_venta = 28;

-- Verificar que quedó bien
SELECT 
    v.id_venta,
    v.importe,
    v.ganancia_t,
    (SELECT SUM(dv.importe_r) FROM detalle_venta dv WHERE dv.id_venta = 28) AS suma_detalle
FROM ventas v
WHERE v.id_venta = 28;

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================


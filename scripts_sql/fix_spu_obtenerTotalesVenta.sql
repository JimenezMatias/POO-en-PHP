-- =====================================================
-- CORREGIR SPU OBTENER TOTALES DE VENTA
-- =====================================================

DROP PROCEDURE IF EXISTS spu_obtenerTotalesVenta;

DELIMITER $$

CREATE PROCEDURE spu_obtenerTotalesVenta(
    IN p_id_venta INT
)
BEGIN
    SELECT 
        -- Cantidad total de productos (suma de todas las cantidades)
        COALESCE(SUM(dv.cant), 0) AS cantidad_productos,
        
        -- Total neto (sin IVA)
        COALESCE(SUM(p.precio_venta * dv.cant), 0) AS total_neto,
        
        -- IVA 10.5% (solo productos con tasa de IVA 10.5%)
        COALESCE(SUM(
            CASE 
                WHEN ti.importe_iva = 10.5 THEN (p.precio_venta * dv.cant * 0.105)
                ELSE 0 
            END
        ), 0) AS iva_10_5,
        
        -- IVA 21% (solo productos con tasa de IVA 21%)
        COALESCE(SUM(
            CASE 
                WHEN ti.importe_iva = 21 THEN (p.precio_venta * dv.cant * 0.21)
                ELSE 0 
            END
        ), 0) AS iva_21,
        
        -- Total final (neto + IVAs)
        COALESCE(SUM(
            p.precio_venta * dv.cant + 
            CASE 
                WHEN ti.importe_iva = 10.5 THEN (p.precio_venta * dv.cant * 0.105)
                WHEN ti.importe_iva = 21 THEN (p.precio_venta * dv.cant * 0.21)
                ELSE 0 
            END
        ), 0) AS total_final
        
    FROM detalle_venta dv
    INNER JOIN productos p ON dv.codigo = p.codigo
    LEFT JOIN tasas_iva ti ON p.id_tasa_iva = ti.id_tasa_iva
    WHERE dv.id_venta = p_id_venta;
END $$

DELIMITER ;

-- =====================================================
-- FIN DEL SPU CORREGIDO
-- =====================================================


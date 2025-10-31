-- =====================================================
-- CORREGIR SPU OBTENER TOTALES - USAR CAMPOS CORRECTOS
-- Los precios YA incluyen IVA, usar campos calculados
-- =====================================================

DROP PROCEDURE IF EXISTS spu_obtenerTotalesVenta;

DELIMITER $$

CREATE PROCEDURE spu_obtenerTotalesVenta(
    IN p_id_venta INT
)
BEGIN
    SELECT 
        -- Cantidad total de productos
        COALESCE(SUM(dv.cant), 0) AS cantidad_productos,
        
        -- Total neto SIN IVA (base imponible)
        COALESCE(SUM(dv.importe_r_bi), 0) AS total_neto,
        
        -- IVA 10.5% (suma de IVAs de productos con tasa 10.5%)
        COALESCE(SUM(
            CASE 
                WHEN ti.importe_iva = 10.5 THEN dv.importe_r_iva
                ELSE 0 
            END
        ), 0) AS iva_10_5,
        
        -- IVA 21% (suma de IVAs de productos con tasa 21%)
        COALESCE(SUM(
            CASE 
                WHEN ti.importe_iva = 21 THEN dv.importe_r_iva
                ELSE 0 
            END
        ), 0) AS iva_21,
        
        -- Total final CON IVA (lo que paga el cliente)
        COALESCE(SUM(dv.importe_r), 0) AS total_final
        
    FROM detalle_venta dv
    INNER JOIN productos p ON dv.codigo = p.codigo
    LEFT JOIN tasas_iva ti ON p.id_tasa_iva = ti.id_tasa_iva
    WHERE dv.id_venta = p_id_venta;
END $$

DELIMITER ;

-- =====================================================
-- PROBAR CON LA VENTA 26
-- =====================================================
CALL spu_obtenerTotalesVenta(26);

-- Resultado esperado:
-- cantidad_productos: 5
-- total_neto: 34564.17 (sin IVA)
-- iva_10_5: (suma de productos con IVA 10.5%)
-- iva_21: (suma de productos con IVA 21%)
-- total_final: 38294.51 (con IVA)

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================


-- Script para crear solo los SPUs que faltan
-- Ejecutar en MySQL

-- 1. Verificar si existe spu_ventas_todas
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS spu_ventas_todas()
BEGIN
    SELECT 
        v.id_venta as ID, 
        v.fecha as FECHA_HORA, 
        v.importe as IMPORTE, 
        u.nombre as USUARIO, 
        fp.descrip_forma_pago as FORMA_PAGO 
    FROM ventas v
    INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    ORDER BY v.fecha DESC;
END //
DELIMITER ;

-- 2. Verificar si existe spu_ventas_fp_todas
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS spu_ventas_fp_todas()
BEGIN
    SELECT 
        fp.descrip_forma_pago as FORMA_PAGO, 
        SUM(v.importe) as TOTAL 
    FROM ventas v
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    GROUP BY fp.descrip_forma_pago
    ORDER BY TOTAL DESC;
END //
DELIMITER ;

-- 3. Verificar si existe spu_ventas_fp_hoy
DELIMITER //
CREATE PROCEDURE IF NOT EXISTS spu_ventas_fp_hoy(
    IN p_fecha_hoy DATE
)
BEGIN
    SELECT 
        fp.descrip_forma_pago as FORMA_PAGO, 
        SUM(v.importe) as TOTAL 
    FROM ventas v
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    WHERE DATE(v.fecha) = p_fecha_hoy
    GROUP BY fp.descrip_forma_pago
    ORDER BY TOTAL DESC;
END //
DELIMITER ;

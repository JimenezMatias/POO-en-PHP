-- =====================================================
-- CORRECCIÓN DE SPUs PARA USAR COLUMNA CONSISTENTE
-- Todos los SPUs usan: fp.nombre (no descrip_forma_pago)
-- =====================================================

-- 1. CORREGIR spu_ventas_fecha (ya usa fp.nombre, pero asegurarse)
DROP PROCEDURE IF EXISTS spu_ventas_fecha;

DELIMITER $$

CREATE PROCEDURE spu_ventas_fecha(
    IN p_fecha_desde DATE,
    IN p_fecha_hasta DATE
)
BEGIN
    SELECT 
        v.id_venta as ID, 
        v.fecha as FECHA_HORA, 
        v.importe as IMPORTE, 
        u.nombre as USUARIO, 
        fp.nombre as FORMA_PAGO 
    FROM ventas v
    INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    WHERE DATE(v.fecha) BETWEEN p_fecha_desde AND p_fecha_hasta
    ORDER BY v.fecha DESC;
END $$

DELIMITER ;

-- 2. CORREGIR spu_ventas_fp_fecha (cambiar descrip_forma_pago por nombre)
DROP PROCEDURE IF EXISTS spu_ventas_fp_fecha;

DELIMITER $$

CREATE PROCEDURE spu_ventas_fp_fecha(
    IN p_fecha_desde DATE,
    IN p_fecha_hasta DATE
)
BEGIN
    SELECT 
        fp.nombre as FORMA_PAGO, 
        SUM(v.importe) as TOTAL 
    FROM ventas v
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    WHERE DATE(v.fecha) BETWEEN p_fecha_desde AND p_fecha_hasta
    GROUP BY fp.nombre
    ORDER BY TOTAL DESC;
END $$

DELIMITER ;

-- 3. CORREGIR spu_ventas_fp_todas (cambiar descrip_forma_pago por nombre)
DROP PROCEDURE IF EXISTS spu_ventas_fp_todas;

DELIMITER $$

CREATE PROCEDURE spu_ventas_fp_todas()
BEGIN
    SELECT 
        fp.nombre as FORMA_PAGO, 
        SUM(v.importe) as TOTAL 
    FROM ventas v
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    GROUP BY fp.nombre
    ORDER BY TOTAL DESC;
END $$

DELIMITER ;

-- 4. CORREGIR spu_ventas_hoy (cambiar descrip_forma_pago por nombre)
DROP PROCEDURE IF EXISTS spu_ventas_hoy;

DELIMITER $$

CREATE PROCEDURE spu_ventas_hoy(
    IN p_fecha_hoy DATE
)
BEGIN
    SELECT 
        v.id_venta as ID, 
        v.fecha as FECHA_HORA, 
        v.importe as IMPORTE, 
        u.nombre as USUARIO, 
        fp.nombre as FORMA_PAGO 
    FROM ventas v
    INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    WHERE DATE(v.fecha) = p_fecha_hoy
    ORDER BY v.fecha DESC;
END $$

DELIMITER ;

-- 5. CORREGIR spu_ventas_todas (cambiar descrip_forma_pago por nombre)
DROP PROCEDURE IF EXISTS spu_ventas_todas;

DELIMITER $$

CREATE PROCEDURE spu_ventas_todas()
BEGIN
    SELECT 
        v.id_venta as ID, 
        v.fecha as FECHA_HORA, 
        v.importe as IMPORTE, 
        u.nombre as USUARIO, 
        fp.nombre as FORMA_PAGO 
    FROM ventas v
    INNER JOIN usuarios u ON v.id_usuario = u.id_usuario
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    ORDER BY v.fecha DESC;
END $$

DELIMITER ;

-- 6. CORREGIR spu_ventas_fp_hoy (cambiar descrip_forma_pago por nombre)
DROP PROCEDURE IF EXISTS spu_ventas_fp_hoy;

DELIMITER $$

CREATE PROCEDURE spu_ventas_fp_hoy(
    IN p_fecha_hoy DATE
)
BEGIN
    SELECT 
        fp.nombre as FORMA_PAGO, 
        SUM(v.importe) as TOTAL 
    FROM ventas v
    INNER JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    WHERE DATE(v.fecha) = p_fecha_hoy
    GROUP BY fp.nombre
    ORDER BY TOTAL DESC;
END $$

DELIMITER ;

-- 7. Asegurar que spu_detalle_venta existe correctamente
DROP PROCEDURE IF EXISTS spu_detalle_venta;

DELIMITER $$

CREATE PROCEDURE spu_detalle_venta(
    IN p_id_venta INT
)
BEGIN
    SELECT 
        dv.id_venta as ID,
        dv.codigo as CODIGO,
        p.detalle as DETALLE,
        dv.cant as CANTIDAD,
        ROUND(dv.importe_r / dv.cant, 2) as PRECIO_UNITARIO,
        dv.importe_r as IMPORTE
    FROM detalle_venta dv
    INNER JOIN productos p ON dv.codigo = p.codigo
    WHERE dv.id_venta = p_id_venta
    ORDER BY dv.id_fila;
END $$

DELIMITER ;

-- =====================================================
-- VERIFICACIÓN: Probar que los SPUs funcionan
-- =====================================================

-- Ejemplo de uso:
-- CALL spu_ventas_fecha('2000-01-01', '2027-01-01');
-- CALL spu_ventas_fp_fecha('2000-01-01', '2027-01-01');
-- CALL spu_ventas_hoy(CURDATE());
-- CALL spu_ventas_todas();
-- CALL spu_ventas_fp_todas();
-- CALL spu_ventas_fp_hoy(CURDATE());
-- CALL spu_detalle_venta(1);


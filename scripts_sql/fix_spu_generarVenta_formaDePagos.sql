-- =====================================================
-- CORREGIR SPU GENERAR VENTA - Usar tabla formaDePagos
-- =====================================================

DROP PROCEDURE IF EXISTS spu_generarVenta;

DELIMITER $$

CREATE PROCEDURE spu_generarVenta(
    IN p_id_usuario INT,
    IN p_id_cliente INT,
    IN p_id_forma_pago INT
)
BEGIN
    DECLARE v_id_venta INT;
    
    -- Insertar nueva venta con valores iniciales
    INSERT INTO ventas (
        fecha,
        importe,
        ganancia_t,
        id_usuario,
        id_cliente,
        id_tipo_venta  -- Este campo ahora guarda el id de formaDePagos
    ) VALUES (
        NOW(),
        0,
        0,
        p_id_usuario,
        p_id_cliente,
        p_id_forma_pago
    );
    
    -- Obtener el ID generado de la venta
    SET v_id_venta = LAST_INSERT_ID();
    
    -- Devolver los datos de cabecera para mostrar en el frontend
    SELECT 
        v.id_venta,
        DATE_FORMAT(v.fecha, '%Y-%m-%d %H:%i:%s') AS fecha,
        c.razon_social AS cliente,
        c.nro_doc AS doc_afip,
        c.domicilio,
        c.cp AS localidad,
        fp.nombre AS forma_pago,
        r.descrip_resp_iva AS iva
    FROM ventas v
    LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
    LEFT JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    LEFT JOIN resp_iva r ON c.id_resp_iva = r.id_resp_iva
    WHERE v.id_venta = v_id_venta;
END $$

DELIMITER ;

-- =====================================================
-- CORREGIR SPU ACTUALIZAR CABECERA - Usar formaDePagos
-- Ahora con parámetros opcionales
-- =====================================================

DROP PROCEDURE IF EXISTS spu_actualizarCabeceraVenta;

DELIMITER $$

CREATE PROCEDURE spu_actualizarCabeceraVenta(
    IN p_id_venta INT,
    IN p_id_cliente INT,
    IN p_id_forma_pago INT
)
BEGIN
    -- Actualizar la cabecera de la venta (solo los campos no NULL)
    UPDATE ventas
    SET 
        id_cliente = COALESCE(p_id_cliente, id_cliente),
        id_tipo_venta = COALESCE(p_id_forma_pago, id_tipo_venta)
    WHERE id_venta = p_id_venta;
    
    -- Devolver los datos actualizados de la cabecera
    SELECT 
        v.id_venta,
        DATE_FORMAT(v.fecha, '%Y-%m-%d %H:%i:%s') AS fecha,
        c.razon_social AS cliente,
        c.nro_doc AS doc_afip,
        c.domicilio,
        c.cp AS localidad,
        fp.nombre AS forma_pago,
        r.descrip_resp_iva AS iva
    FROM ventas v
    LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
    LEFT JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
    LEFT JOIN resp_iva r ON c.id_resp_iva = r.id_resp_iva
    WHERE v.id_venta = p_id_venta;
END $$

DELIMITER ;

-- =====================================================
-- FIN DE LOS SPU CORREGIDOS
-- =====================================================


-- =====================================================
-- CORREGIR SPU AGREGAR PRODUCTO CON CÁLCULO DE IVA
-- =====================================================

DROP PROCEDURE IF EXISTS spu_agregarProductoDetalle;

DELIMITER $$

CREATE PROCEDURE spu_agregarProductoDetalle(
    IN p_id_venta INT,
    IN p_codigo VARCHAR(30),
    IN p_cantidad DECIMAL(18,4)
)
BEGIN
    DECLARE v_precio_venta DECIMAL(18,2);
    DECLARE v_costo DECIMAL(18,2);
    DECLARE v_tasa_iva DECIMAL(18,2);
    DECLARE v_existe INT;
    DECLARE v_importe_total DECIMAL(18,2);
    DECLARE v_importe_bi DECIMAL(18,2);
    DECLARE v_importe_iva DECIMAL(18,2);

    -- Obtener precio de venta, costo y tasa de IVA del producto
    SELECT p.precio_venta, p.costo, COALESCE(ti.importe_iva, 0)
    INTO v_precio_venta, v_costo, v_tasa_iva
    FROM productos p
    LEFT JOIN tasas_iva ti ON p.id_tasa_iva = ti.id_tasa_iva
    WHERE p.codigo = p_codigo;

    -- Calcular importes
    -- importe_total = precio_venta * cantidad
    SET v_importe_total = v_precio_venta * p_cantidad;
    
    -- Si hay IVA, calcular base imponible e IVA
    IF v_tasa_iva > 0 THEN
        -- Base imponible = importe_total / (1 + tasa_iva/100)
        SET v_importe_bi = v_importe_total / (1 + (v_tasa_iva / 100));
        -- IVA = importe_total - base_imponible
        SET v_importe_iva = v_importe_total - v_importe_bi;
    ELSE
        -- Sin IVA
        SET v_importe_bi = v_importe_total;
        SET v_importe_iva = 0;
    END IF;

    -- Verificar si el producto ya existe en el detalle
    SELECT COUNT(*) INTO v_existe
    FROM detalle_venta
    WHERE id_venta = p_id_venta AND codigo = p_codigo AND id_fila = 1;

    IF v_existe > 0 THEN
        -- Si existe, sumar la cantidad y recalcular
        UPDATE detalle_venta
        SET 
            cant = cant + p_cantidad,
            importe = v_precio_venta * (cant + p_cantidad),
            importe_r = v_precio_venta * (cant + p_cantidad),
            ganancia_r = (v_precio_venta - v_costo) * (cant + p_cantidad),
            importe_r_bi = (v_precio_venta * (cant + p_cantidad)) / (1 + (v_tasa_iva / 100)),
            importe_r_iva = (v_precio_venta * (cant + p_cantidad)) - ((v_precio_venta * (cant + p_cantidad)) / (1 + (v_tasa_iva / 100)))
        WHERE id_venta = p_id_venta AND codigo = p_codigo AND id_fila = 1;
    ELSE
        -- Si no existe, insertar nuevo registro
        INSERT INTO detalle_venta (
            id_venta,
            codigo,
            costo,
            importe,
            importe_r,
            cant,
            id_fila,
            ganancia_r,
            importe_r_bi,
            importe_r_iva
        ) VALUES (
            p_id_venta,
            p_codigo,
            v_costo,
            v_importe_total,
            v_importe_total,
            p_cantidad,
            1,
            (v_precio_venta - v_costo) * p_cantidad,
            v_importe_bi,
            v_importe_iva
        );
    END IF;

    -- Devolver el detalle completo actualizado con JOIN a productos
    SELECT 
        dv.id_venta,
        dv.codigo,
        p.detalle,
        dv.cant,
        p.precio_venta,
        (p.precio_venta * dv.cant) AS total,
        dv.importe_r,
        dv.costo,
        dv.importe,
        dv.ganancia_r,
        dv.id_fila,
        dv.importe_r_bi,
        dv.importe_r_iva
    FROM detalle_venta dv
    INNER JOIN productos p ON dv.codigo = p.codigo
    WHERE dv.id_venta = p_id_venta
    ORDER BY dv.codigo;
END $$

DELIMITER ;

-- =====================================================
-- FIN DEL SPU CORREGIDO
-- =====================================================


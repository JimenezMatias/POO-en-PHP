-- =====================================================
-- SCRIPT COMPLETO PARA CORREGIR TODO EL SISTEMA
-- DE FORMAS DE PAGO
-- =====================================================

-- =====================================================
-- PASO 1: ASEGURAR QUE formaDePagos TENGA DATOS
-- =====================================================

-- Actualizar el registro con id=1 para que sea "Efectivo"
UPDATE formaDePagos 
SET nombre = 'Efectivo' 
WHERE id_formaDePago = 1;

-- Si no existe el registro con id=1, insertarlo
INSERT IGNORE INTO formaDePagos (id_formaDePago, nombre)
VALUES (1, 'Efectivo');

-- Ver contenido actual de formaDePagos
SELECT * FROM formaDePagos ORDER BY id_formaDePago;

-- =====================================================
-- PASO 2: ACTUALIZAR VENTAS EXISTENTES
-- =====================================================

-- Ver si hay ventas con id_tipo_venta que no existen en formaDePagos
SELECT DISTINCT v.id_tipo_venta, COUNT(*) as cantidad
FROM ventas v
LEFT JOIN formaDePagos fp ON v.id_tipo_venta = fp.id_formaDePago
WHERE fp.id_formaDePago IS NULL AND v.id_tipo_venta IS NOT NULL
GROUP BY v.id_tipo_venta;

-- Actualizar todas las ventas para que usen id_tipo_venta = 1 (Efectivo)
-- si tienen un valor que no existe en formaDePagos
UPDATE ventas 
SET id_tipo_venta = 1 
WHERE id_tipo_venta NOT IN (SELECT id_formaDePago FROM formaDePagos) 
   OR id_tipo_venta IS NULL;

-- =====================================================
-- PASO 3: ELIMINAR Y RECREAR FOREIGN KEY
-- =====================================================

-- Eliminar la foreign key vieja que apunta a tipos_ventas
ALTER TABLE ventas
DROP FOREIGN KEY ventas_ibfk_3;

-- Crear la foreign key nueva que apunta a formaDePagos
ALTER TABLE ventas
ADD CONSTRAINT fk_ventas_formaDePago 
FOREIGN KEY (id_tipo_venta) REFERENCES formaDePagos(id_formaDePago)
ON DELETE RESTRICT
ON UPDATE CASCADE;

-- =====================================================
-- PASO 4: RECREAR STORED PROCEDURES
-- =====================================================

-- SPU: GENERAR VENTA
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
        id_tipo_venta
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

-- SPU: ACTUALIZAR CABECERA
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
-- PASO 5: VERIFICACIÓN FINAL
-- =====================================================

-- Ver estructura de la tabla ventas
SHOW CREATE TABLE ventas;

-- Probar el SPU con datos de prueba
-- CALL spu_generarVenta(1, 1, 1);

-- =====================================================
-- FIN DEL SCRIPT COMPLETO
-- =====================================================


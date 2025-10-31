-- Corregir SPU para obtener el detalle de la venta con información de productos

DROP PROCEDURE IF EXISTS spu_obtenerDetalleVenta;

DELIMITER $$

CREATE PROCEDURE spu_obtenerDetalleVenta(
    IN p_id_venta INT
)
BEGIN
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


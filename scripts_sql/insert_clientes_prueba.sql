-- =====================================================
-- INSERTS DE CLIENTES PARA PRUEBA
-- =====================================================

-- Cliente 2: Comercio "La Esquina S.R.L." - Responsable Inscripto
INSERT INTO clientes (
    id_cliente,
    razon_social,
    domicilio,
    cp,
    id_tipo_doc,
    nro_doc,
    id_resp_iva,
    id_tipo_doc_afip,
    limite_cc
) VALUES (
    2,
    'La Esquina S.R.L.',
    'Av. San Martin 1234',
    5000,                    -- CP de Córdoba (ajustá según tu tabla localidades)
    1,                       -- id_tipo_doc (ajustá según tu tabla tipos_doc)
    '30-12345678-9',         -- CUIT
    1,                       -- 1 = Responsable Inscripto
    80,                      -- 80 = CUIT (AFIP)
    50000.00                 -- Límite de cuenta corriente
);

-- Cliente 3: Persona "Juan Pérez" - Monotributista
INSERT INTO clientes (
    id_cliente,
    razon_social,
    domicilio,
    cp,
    id_tipo_doc,
    nro_doc,
    id_resp_iva,
    id_tipo_doc_afip,
    limite_cc
) VALUES (
    3,
    'Juan Pérez',
    'Calle Falsa 456',
    5000,                    -- CP de Córdoba
    1,                       -- id_tipo_doc
    '20-98765432-1',         -- CUIT de Monotributista
    2,                       -- 2 = Monotributista
    80,                      -- 80 = CUIT (AFIP)
    15000.00                 -- Límite de cuenta corriente
);

-- =====================================================
-- Verificar los clientes insertados
-- =====================================================

SELECT 
    c.id_cliente,
    c.razon_social,
    c.domicilio,
    c.nro_doc,
    r.descrip_resp_iva AS condicion_iva
FROM clientes c
LEFT JOIN resp_iva r ON c.id_resp_iva = r.id_resp_iva
ORDER BY c.id_cliente;

-- =====================================================
-- FIN DEL SCRIPT
-- =====================================================


<?php
namespace App\Modelos;

use PDO;

class ClientesRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("
            SELECT 
                c.id_cliente,
                c.razon_social,
                c.domicilio,
                c.cp,
                c.id_tipo_doc,
                c.nro_doc,
                c.id_resp_iva,
                c.id_tipo_doc_afip,
                c.limite_cc,
                r.descrip_resp_iva AS iva,
                td.descrip_tipo_doc AS tipo_doc,
                tda.descrip_tipo_doc_afip AS tipo_doc_afip
            FROM clientes c
            LEFT JOIN resp_iva r ON c.id_resp_iva = r.id_resp_iva
            LEFT JOIN tipos_doc td ON c.id_tipo_doc = td.id_tipo_doc
            LEFT JOIN tipos_doc_afip tda ON c.id_tipo_doc_afip = tda.id_tipo_doc_afip
            ORDER BY c.razon_social
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.id_cliente,
                c.razon_social,
                c.domicilio,
                c.cp,
                c.id_tipo_doc,
                c.nro_doc,
                c.id_resp_iva,
                c.id_tipo_doc_afip,
                c.limite_cc,
                r.descrip_resp_iva AS iva,
                td.descrip_tipo_doc AS tipo_doc,
                tda.descrip_tipo_doc_afip AS tipo_doc_afip
            FROM clientes c
            LEFT JOIN resp_iva r ON c.id_resp_iva = r.id_resp_iva
            LEFT JOIN tipos_doc td ON c.id_tipo_doc = td.id_tipo_doc
            LEFT JOIN tipos_doc_afip tda ON c.id_tipo_doc_afip = tda.id_tipo_doc_afip
            WHERE c.id_cliente = :id
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function crear(array $data): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO clientes 
            (razon_social, domicilio, cp, id_tipo_doc, nro_doc, id_resp_iva, id_tipo_doc_afip, limite_cc) 
            VALUES 
            (:razon_social, :domicilio, :cp, :id_tipo_doc, :nro_doc, :id_resp_iva, :id_tipo_doc_afip, :limite_cc)
        ");
        return $stmt->execute($data);
    }

    public function editar(int $id, array $data): bool {
        $stmt = $this->pdo->prepare("
            UPDATE clientes SET
                razon_social = :razon_social,
                domicilio = :domicilio,
                cp = :cp,
                id_tipo_doc = :id_tipo_doc,
                nro_doc = :nro_doc,
                id_resp_iva = :id_resp_iva,
                id_tipo_doc_afip = :id_tipo_doc_afip,
                limite_cc = :limite_cc
            WHERE id_cliente = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function eliminar(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id_cliente = :id");
        return $stmt->execute(['id' => $id]);
    }
}


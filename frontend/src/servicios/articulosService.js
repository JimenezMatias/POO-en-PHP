import { getToken } from './authService';

const API_URL = 'http://localhost/articulos';

const sanitizeArticulo = (row) => ({
  codigo: row.codigo ?? '',
  detalle: row.detalle ?? '',
  costo: parseFloat(row.costo) || 0,
  porcen: parseFloat(row.porcen) || 0,
  precio_venta: parseFloat(row.precio_venta) || 0,
  stock: row.stock !== undefined && row.stock !== null && row.stock !== ''
    ? Number(row.stock)
    : 0,
  id_ubicacion: row.id_ubicacion ?? '',
  id_proveedor: row.id_proveedor ?? '',
  id_rubro: row.id_rubro ?? '',
  codigo_uni_medida: row.codigo_uni_medida ?? '',
  id_tasa_iva: row.id_tasa_iva ?? '',
  punto_pedido: parseFloat(row.punto_pedido) || 0,
  bonif: parseFloat(row.bonif) || 0,
  obsv: row.obsv ?? '',
});

export const listarArticulos = async () => {
  try {
    const res = await fetch(API_URL, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) {
      throw new Error(`Error ${res.status}: ${res.statusText}`);
    }

    const data = await res.json();
    
    return data.map(sanitizeArticulo);
  } catch (err) {
    console.error('Error al listar artículos:', err);
    throw err;
  }
};

export const crearArticulo = async (payload) => {
  try {
    const res = await fetch(API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(payload),
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw new Error(errorData.error || `Error ${res.status}`);
    }

    const nuevo = await res.json();
    return sanitizeArticulo(nuevo);
  } catch (err) {
    console.error('Error al crear artículo:', err);
    throw err;
  }
};

//  Actualizar artículo
export const actualizarArticulo = async (codigo, payload) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(payload),
    });

    if (!res.ok) {
      const errorData = await res.json().catch(() => ({}));
      throw new Error(errorData.error || `Error ${res.status}`);
    }

    const actualizado = await res.json();
    return sanitizeArticulo(actualizado);
  } catch (err) {
    console.error('Error al actualizar artículo:', err);
    throw err;
  }
};

//  Eliminar artículo
export const eliminarArticulo = async (codigo) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) {
      const errorData = await res.json().catch(() => ({}));
      throw new Error(errorData.error || `Error ${res.status}`);
    }

    return { success: true, codigo };
  } catch (err) {
    console.error('Error al eliminar artículo:', err);
    throw err;
  }
};



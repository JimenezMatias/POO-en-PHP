// src/servicios/ventasService.js
import { getToken } from "./authService";

const API_URL = "http://localhost/ventas";

/**
 * Inicia una nueva venta (llama al SPU spu_generarVenta)
 */
export const iniciarVenta = async (idUsuario, idCliente, idTipoVenta) => {
  try {
    const response = await fetch(`${API_URL}/iniciar`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
      body: JSON.stringify({
        id_usuario: Number(idUsuario),
        id_cliente: Number(idCliente),
        id_tipo_venta: Number(idTipoVenta),
      }),
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al iniciar venta: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Venta iniciada:", data);
    return data;
  } catch (error) {
    console.error("❌ Error en iniciarVenta:", error);
    throw error;
  }
};

/**
 * Actualiza la cabecera de venta: cliente y/o forma de pago
 * (El IVA se trae automáticamente del cliente)
 */
export const actualizarCabecera = async (idVenta, datos) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/cabecera`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
      body: JSON.stringify(datos),
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al actualizar cabecera: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Cabecera actualizada:", data);
    return data;
  } catch (error) {
    console.error("❌ Error en actualizarCabecera:", error);
    throw error;
  }
};

/**
 * Agrega un producto al detalle de la venta
 * Si el producto ya existe, suma la cantidad
 */
export const agregarProducto = async (idVenta, codigo, cantidad) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/detalle`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
      body: JSON.stringify({
        codigo,
        cantidad: Number(cantidad),
      }),
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al agregar producto: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Producto agregado:", data);
    return data;
  } catch (error) {
    console.error("❌ Error en agregarProducto:", error);
    throw error;
  }
};

/**
 * Elimina un producto del detalle de la venta (por código)
 * Elimina TODAS las unidades de ese producto
 */
export const eliminarProducto = async (idVenta, codigo) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/detalle/${codigo}`, {
      method: "DELETE",
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al eliminar producto: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Producto eliminado:", data);
    return data;
  } catch (error) {
    console.error("❌ Error en eliminarProducto:", error);
    throw error;
  }
};

/**
 * Obtiene el detalle completo de la venta
 */
export const obtenerDetalle = async (idVenta) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/detalle`, {
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener detalle: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en obtenerDetalle:", error);
    throw error;
  }
};

/**
 * Obtiene los totales calculados de la venta
 */
export const obtenerTotales = async (idVenta) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/totales`, {
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener totales: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en obtenerTotales:", error);
    throw error;
  }
};

/**
 * Finaliza la venta (actualiza totales y descuenta stock)
 */
export const finalizarVenta = async (idVenta) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/finalizar`, {
      method: "POST",
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al finalizar venta: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Venta finalizada:", data);
    return data;
  } catch (error) {
    console.error("❌ Error en finalizarVenta:", error);
    throw error;
  }
};

/**
 * Cancela la venta (elimina cabecera y detalle)
 */
export const cancelarVenta = async (idVenta) => {
  try {
    const response = await fetch(`${API_URL}/${idVenta}/cancelar`, {
      method: "POST",
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al cancelar venta: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Venta cancelada:", data);
    return data;
  } catch (error) {
    console.error("❌ Error en cancelarVenta:", error);
    throw error;
  }
};

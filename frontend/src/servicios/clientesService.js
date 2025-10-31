// src/servicios/clientesService.js
import { getToken } from "./authService";

const API_URL = "http://localhost/clientes";

/**
 * Lista todos los clientes con su información de IVA
 */
export const listarClientes = async () => {
  try {
    const response = await fetch(API_URL, {
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al listar clientes: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en listarClientes:", error);
    throw error;
  }
};

/**
 * Obtiene un cliente por su ID
 */
export const obtenerCliente = async (idCliente) => {
  try {
    const response = await fetch(`${API_URL}/${idCliente}`, {
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener cliente: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en obtenerCliente:", error);
    throw error;
  }
};

/**
 * Crea un nuevo cliente
 */
export const crearCliente = async (datosCliente) => {
  try {
    const response = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
      body: JSON.stringify(datosCliente),
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al crear cliente: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en crearCliente:", error);
    throw error;
  }
};

/**
 * Edita un cliente existente
 */
export const editarCliente = async (idCliente, datosCliente) => {
  try {
    const response = await fetch(`${API_URL}/${idCliente}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
      body: JSON.stringify(datosCliente),
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al editar cliente: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en editarCliente:", error);
    throw error;
  }
};

/**
 * Elimina un cliente
 */
export const eliminarCliente = async (idCliente) => {
  try {
    const response = await fetch(`${API_URL}/${idCliente}`, {
      method: "DELETE",
      headers: {
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al eliminar cliente: ${errorText}`);
    }

    return await response.json();
  } catch (error) {
    console.error("❌ Error en eliminarCliente:", error);
    throw error;
  }
};


import { getToken } from "./authService";

const API_URL = "http://localhost/articulos";

// Buscar artículo por código
export const buscarArticuloPorCodigo = async (codigo) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw errorData;
    }

    return await res.json();
  } catch (error) {
    console.error("Error al buscar artículo:", error);
    throw error;
  }
};

// Sumar stock (permite positivos y negativos)
export const sumarStock = async (codigo, cantidad) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}/stock`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ cantidad }),
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw errorData;
    }

    return await res.json();
  } catch (error) {
    console.error("Error al actualizar stock:", error);
    throw error;
  }
};

// Actualizar precio de venta
export const actualizarPrecio = async (codigo, precio) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}/precio`, {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ precio }),
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw errorData;
    }

    return await res.json();
  } catch (error) {
    console.error("Error al actualizar precio:", error);
    throw error;
  }
};


import { getToken } from "./authService";

const API_URL = "http://localhost/ubicaciones"; // 

// Listar ubicaciones
export const listarUbicaciones = async () => {
  try {
    const res = await fetch(API_URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) throw new Error("Error al listar ubicaciones");
    return await res.json();
  } catch (error) {
    console.error(error);
    return []; // Devuelve array vacío si falla
  }
};

// Crear ubicación
export const crearUbicacion = async (desc_ubicacion) => {
  try {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ desc_ubicacion }),
    });

    if (!res.ok) throw new Error("Error al crear ubicación");
    return await res.json();
  } catch (error) {
    console.error(error);
    throw error; // Propaga el error
  }
};

// Editar ubicación
export const editarUbicacion = async (id, desc_ubicacion) => {
  try {
    const res = await fetch(`${API_URL}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ desc_ubicacion }),
    });

    if (!res.ok) throw new Error("Error al editar ubicación");
    return await res.json();
  } catch (error) {
    console.error(error);
    throw error;
  }
};

// Eliminar ubicación
export const eliminarUbicacion = async (id) => {
  try {
    const res = await fetch(`${API_URL}/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) throw new Error("Error al eliminar ubicación");
    return await res.json();
  } catch (error) {
    console.error(error);
    throw error;
  }
};

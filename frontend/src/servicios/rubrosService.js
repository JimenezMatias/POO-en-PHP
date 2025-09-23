import { getToken } from "./authService"; 

const URL_BASE = "http://localhost/rubros"; // backend

// Listar todos los Rubros
export async function listarRubros() {
  try {
    const response = await fetch(URL_BASE, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`
      }
    });

    if (!response.ok) throw new Error("Error al listar Rubros");

    return await response.json(); // se espera un array de Rubros
  } catch (error) {
    console.error(error);
    return [];
  }
}

// Crear un nuevo Rubro
export async function crearRubro(nombre) {
  try {
    const response = await fetch(URL_BASE, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ nombre }),
    });

    if (!response.ok) throw new Error("Error al crear Rubro");

    return await response.json(); // se espera la forma creada
  } catch (error) {
    console.error(error);
  }
}

// Editar un Rubro existente
export async function editarRubro(id, desc_rubro) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ desc_rubro }),
    });

    if (!response.ok) throw new Error("Error al editar Rubro");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

// Eliminar un Rubro
export async function eliminarRubro(id) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) throw new Error("Error al eliminar Rubro");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

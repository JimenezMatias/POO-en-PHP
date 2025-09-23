import { getToken } from "./authService"; 

const URL_BASE = "http://localhost/localidades"; // backend

// Listar todas las localidades
export async function listarLocalidades() {
  try {
    const response = await fetch(URL_BASE, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`
      }
    });

    if (!response.ok) throw new Error("Error al listar localidades");

    return await response.json(); // se espera un array
  } catch (error) {
    console.error(error);
    return [];
  }
}

// Crear una nueva localidad
export async function crearLocalidad(localidad) {
  try {
    const response = await fetch(URL_BASE, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(localidad),
    });

    if (!response.ok) throw new Error("Error al crear una localidad");

    return await response.json(); // se espera la localidad creada
  } catch (error) {
    console.error(error);
  }
}

// Editar una localidad existente
export async function editarLocalidad(id, localidad) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(localidad),
    });

    if (!response.ok) throw new Error("Error al editar localidad");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

// Eliminar una localidad
export async function eliminarLocalidad(id) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) throw new Error("Error al eliminar localidad");

    return true; // si llegó acá, la eliminación fue exitosa
  } catch (error) {
    console.error(error);
    return false;
  }
}

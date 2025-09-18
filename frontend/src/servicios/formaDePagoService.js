import { getToken } from "./authService"; 

const URL_BASE = "http://localhost/formas-de-pago"; // backend

// Listar todas las formas de pago
export async function listarFormasDePago() {
  try {
    const response = await fetch(URL_BASE, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`
      }
    });

    if (!response.ok) throw new Error("Error al listar formas de pago");

    return await response.json(); // se espera un array de formas de pago
  } catch (error) {
    console.error(error);
    return [];
  }
}

// Crear una nueva forma de pago
export async function crearFormaDePago(nombre) {
  try {
    const response = await fetch(URL_BASE, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ nombre }),
    });

    if (!response.ok) throw new Error("Error al crear forma de pago");

    return await response.json(); // se espera la forma creada
  } catch (error) {
    console.error(error);
  }
}

// Editar una forma de pago existente
export async function editarFormaDePago(id, nombre) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify({ nombre }),
    });

    if (!response.ok) throw new Error("Error al editar forma de pago");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

// Eliminar una forma de pago
export async function eliminarFormaDePago(id) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) throw new Error("Error al eliminar forma de pago");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

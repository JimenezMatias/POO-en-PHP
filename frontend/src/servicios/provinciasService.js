import { getToken } from "./authService";

const URL_BASE = "http://localhost/provincias";

// Listar todas las provincias
export async function listarProvincias() {
  try {
    const response = await fetch(URL_BASE, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`
      }
    });

    if (!response.ok) throw new Error("Error al listar provincias");

    return await response.json(); // se espera un array
  } catch (error) {
    console.error(error);
    return [];
  }
}

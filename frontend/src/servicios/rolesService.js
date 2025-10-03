import { getToken } from "./authService";

const URL_BASE = "http://localhost/roles"; // endpoint de tu backend Slim

// Listar todos los Roles
export async function listarRoles() {
  try {
    const response = await fetch(URL_BASE, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`
      }
    });

    if (!response.ok) throw new Error("Error al listar Roles");

    return await response.json(); // se espera un array de roles
  } catch (error) {
    console.error(error);
    return [];
  }
}


// src/servicios/usuariosService.js

import { getToken } from "./authService"; 

const URL_BASE = "http://localhost/usuarios"; // backend

// Listar todos los Usuarios
export async function listarUsuarios() {
  try {
    const response = await fetch(URL_BASE, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`
      }
    });

    if (!response.ok) throw new Error("Error al listar Usuarios");

    return await response.json(); // se espera un array de Usuarios
  } catch (error) {
    console.error(error);
    return [];
  }
}

// Crear un nuevo Usuario
export async function crearUsuario(usuario) {
  try {
    const response = await fetch(URL_BASE, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(usuario), // se espera un objeto { nombre, email, password, etc. }
    });

    if (!response.ok) throw new Error("Error al crear Usuario");

    return await response.json(); // se espera el usuario creado
  } catch (error) {
    console.error(error);
  }
}

// Editar un Usuario existente
export async function editarUsuario(id, usuario) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(usuario), // se espera un objeto { nombre, email, etc. }
    });

    if (!response.ok) throw new Error("Error al editar Usuario");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

// Eliminar un Usuario
export async function eliminarUsuario(id) {
  try {
    const response = await fetch(`${URL_BASE}/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) throw new Error("Error al eliminar Usuario");

    return await response.json();
  } catch (error) {
    console.error(error);
  }
}

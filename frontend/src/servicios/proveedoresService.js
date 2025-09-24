// src/servicios/proveedoresService.js

import { getToken } from "./authService"; 

const API_URL = "http://localhost/proveedores"; // 

// Listar proveedores
export const listarProveedores = async () => {
  try {
    const res = await fetch(API_URL, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) throw new Error("Error al listar proveedores");
    return await res.json();
  } catch (error) {
    console.error(error);
    return []; // Devuelve array vacío si falla
  }
};

// Crear proveedor
export const crearProveedor = async (proveedor) => {
  try {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(proveedor),
    });

    if (!res.ok) throw new Error("Error al crear proveedor");
    return await res.json();
  } catch (error) {
    console.error(error);
    throw error; // Propaga el error para manejarlo en el componente
  }
};

// Editar proveedor
export const editarProveedor = async (id, proveedor) => {
  try {
    const res = await fetch(`${API_URL}/${id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(proveedor),
    });

    if (!res.ok) throw new Error("Error al editar proveedor");
    return await res.json();
  } catch (error) {
    console.error(error);
    throw error;
  }
};

// Eliminar proveedor
export const eliminarProveedor = async (id) => {
  try {
    const res = await fetch(`${API_URL}/${id}`, {
      method: "DELETE",
      headers: {
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) throw new Error("Error al eliminar proveedor");
    return await res.json();
  } catch (error) {
    console.error(error);
    throw error;
  }
};

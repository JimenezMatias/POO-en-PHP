// src/servicios/articulosService.js
import { getToken } from './authService';

const API_URL = 'http://localhost/articulos';

// Listar todos los artículos
export const listarArticulos = async () => {
  try {
    const res = await fetch(API_URL, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) {
      throw new Error(`Error ${res.status}: ${res.statusText}`);
    }
    
    return await res.json();
  } catch (err) {
    console.error('Error al listar artículos:', err);
    throw err;
  }
};

// Crear un artículo
export const crearArticulo = async (payload) => {
  try {
    const res = await fetch(API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(payload),
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw new Error(errorData.error || `Error ${res.status}`);
    }

    return await res.json();
  } catch (err) {
    console.error('Error al crear artículo:', err);
    throw err;
  }
};

// Actualizar un artículo
export const actualizarArticulo = async (codigo, payload) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
      body: JSON.stringify(payload),
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw new Error(errorData.error || `Error ${res.status}`);
    }

    return await res.json();
  } catch (err) {
    console.error('Error al actualizar artículo:', err);
    throw err;
  }
};

// Eliminar un artículo
export const eliminarArticulo = async (codigo) => {
  try {
    const res = await fetch(`${API_URL}/${codigo}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getToken()}`,
      },
    });

    if (!res.ok) {
      const errorData = await res.json();
      throw new Error(errorData.error || `Error ${res.status}`);
    }

    return true;
  } catch (err) {
    console.error('Error al eliminar artículo:', err);
    throw err;
  }
};

import { getToken } from './authService';

const API_URL = 'http://localhost/tipos-doc';

/**
 * Lista todos los tipos de documentos
 */
export const listarTiposDoc = async () => {
  try {
    const response = await fetch(API_URL, {
      headers: {
        'Authorization': `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      throw new Error(`Error ${response.status}: ${response.statusText}`);
    }

    return await response.json();
  } catch (error) {
    console.error('Error al listar tipos de documentos:', error);
    throw error;
  }
};

/**
 * Obtiene un tipo de documento por ID
 */
export const obtenerTipoDoc = async (id) => {
  try {
    const response = await fetch(`${API_URL}/${id}`, {
      headers: {
        'Authorization': `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      throw new Error(`Error ${response.status}: ${response.statusText}`);
    }

    return await response.json();
  } catch (error) {
    console.error('Error al obtener tipo de documento:', error);
    throw error;
  }
};


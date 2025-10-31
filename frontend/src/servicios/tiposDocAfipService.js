import { getToken } from './authService';

const API_URL = 'http://localhost/tipos-doc-afip';

/**
 * Lista todos los tipos de documentos AFIP
 */
export const listarTiposDocAfip = async () => {
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
    console.error('Error al listar tipos de documentos AFIP:', error);
    throw error;
  }
};

/**
 * Obtiene un tipo de documento AFIP por ID
 */
export const obtenerTipoDocAfip = async (id) => {
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
    console.error('Error al obtener tipo de documento AFIP:', error);
    throw error;
  }
};


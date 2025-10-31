import { getToken } from './authService';

const API_URL = 'http://localhost/resp-iva';

/**
 * Lista todas las responsabilidades de IVA
 */
export const listarRespIva = async () => {
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
    console.error('Error al listar responsabilidades de IVA:', error);
    throw error;
  }
};

/**
 * Obtiene una responsabilidad de IVA por ID
 */
export const obtenerRespIva = async (id) => {
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
    console.error('Error al obtener responsabilidad de IVA:', error);
    throw error;
  }
};


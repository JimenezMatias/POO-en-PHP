import { getToken } from './authService';

const API_URL = 'http://localhost/unidades_medida';

export const listarUnidadesMedida = async () => {
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

    const data = await res.json();
    
    return data; 
  } catch (err) {
    console.error('Error al listar unidades de medida:', err);
    return [];
  }
};

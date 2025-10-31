import { getToken } from './authService';

const API_URL = 'http://localhost/tasas_iva';

export const listarTasasIva = async () => {
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
    
    return data; // asumimos { id_tasa_iva, descripcion } o similar
  } catch (err) {
    console.error('Error al listar tasas de IVA:', err);
    return [];
  }
};

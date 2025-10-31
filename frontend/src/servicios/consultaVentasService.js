// src/servicios/consultaVentasService.js
import { getToken } from "./authService";

const API_URL = "http://localhost/consulta-ventas";

/**
 * Consultar ventas por rango de fechas
 */
export const consultarVentas = async (desde, hasta) => {
  try {
    // Construir URL con query params solo si hay fechas
    let url = API_URL;
    const params = new URLSearchParams();
    
    if (desde) params.append('desde', desde);
    if (hasta) params.append('hasta', hasta);
    
    if (params.toString()) {
      url += `?${params.toString()}`;
    }
    
    console.log("🔍 Consultando ventas:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al consultar ventas: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Ventas consultadas:", data.length, "registros");
    return data;
  } catch (error) {
    console.error("❌ Error en consultarVentas:", error);
    throw error;
  }
};

/**
 * Consultar todas las ventas
 */
export const consultarTodasVentas = async () => {
  try {
    const url = `${API_URL}/todas`;
    console.log("🔍 Consultando todas las ventas:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al consultar todas las ventas: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Todas las ventas consultadas:", data.length, "registros");
    return data;
  } catch (error) {
    console.error("❌ Error en consultarTodasVentas:", error);
    throw error;
  }
};

/**
 * Consultar ventas de hoy
 */
export const consultarVentasHoy = async (fecha) => {
  try {
    let url = `${API_URL}/hoy`;
    
    if (fecha) {
      url += `?fecha=${fecha}`;
    }
    
    console.log("🔍 Consultando ventas de hoy:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al consultar ventas de hoy: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Ventas de hoy consultadas:", data.length, "registros");
    return data;
  } catch (error) {
    console.error("❌ Error en consultarVentasHoy:", error);
    throw error;
  }
};

/**
 * Obtener detalle de una venta
 */
export const obtenerDetalleVenta = async (idVenta) => {
  try {
    const url = `${API_URL}/${idVenta}/detalle`;
    console.log("🔍 Obteniendo detalle de venta:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener detalle de venta: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Detalle de venta obtenido:", data.length, "productos");
    return data;
  } catch (error) {
    console.error("❌ Error en obtenerDetalleVenta:", error);
    throw error;
  }
};

/**
 * Resumen por forma de pago por fechas
 */
export const resumenFormasPago = async (desde, hasta) => {
  try {
    // Construir URL con query params solo si hay fechas
    let url = `${API_URL}/resumen`;
    const params = new URLSearchParams();
    
    if (desde) params.append('desde', desde);
    if (hasta) params.append('hasta', hasta);
    
    if (params.toString()) {
      url += `?${params.toString()}`;
    }
    
    console.log("🔍 Obteniendo resumen formas de pago:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener resumen de formas de pago: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Resumen formas de pago obtenido:", data.length, "formas de pago");
    return data;
  } catch (error) {
    console.error("❌ Error en resumenFormasPago:", error);
    throw error;
  }
};

/**
 * Resumen todas las formas de pago
 */
export const resumenTodasFormasPago = async () => {
  try {
    const url = `${API_URL}/resumen/todas`;
    console.log("🔍 Obteniendo resumen todas las formas de pago:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener resumen de todas las formas de pago: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Resumen todas las formas de pago obtenido:", data.length, "formas de pago");
    return data;
  } catch (error) {
    console.error("❌ Error en resumenTodasFormasPago:", error);
    throw error;
  }
};

/**
 * Resumen formas de pago de hoy
 */
export const resumenFormasPagoHoy = async (fecha) => {
  try {
    let url = `${API_URL}/resumen/hoy`;
    
    if (fecha) {
      url += `?fecha=${fecha}`;
    }
    
    console.log("🔍 Obteniendo resumen formas de pago de hoy:", url);
    
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${getToken()}`,
      },
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(`Error al obtener resumen de formas de pago de hoy: ${errorText}`);
    }

    const data = await response.json();
    console.log("✅ Resumen formas de pago de hoy obtenido:", data.length, "formas de pago");
    return data;
  } catch (error) {
    console.error("❌ Error en resumenFormasPagoHoy:", error);
    throw error;
  }
};
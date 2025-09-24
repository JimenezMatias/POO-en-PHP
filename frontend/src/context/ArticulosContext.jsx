// src/context/ArticulosContext.jsx
import React, { createContext, useContext, useState, useCallback } from "react";
import { listarArticulos } from "../servicios/articulosService";

const ArticulosContext = createContext();

// Provider que envuelve la app y mantiene los artículos en memoria
export const ArticulosProvider = ({ children }) => {
  const [articulos, setArticulos] = useState([]); // array vacío inicial
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  // Función para traer los artículos desde el backend
  const fetchArticulos = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const data = await listarArticulos();
      console.log('Data recibida del backend:', data);
      // Sanitizamos cada fila para asegurarnos que todas las columnas tengan un valor válido
      const sanitizedData = data.map((row) => ({
        codigo: row.codigo ?? '',
        detalle: row.detalle ?? '',
        costo: parseFloat(row.costo) || 0,
        porcen: parseFloat(row.porcen) || 0,
        precio_venta: parseFloat(row.precio_venta) || 0,
        stock:  row.stock !== undefined && row.stock !== null && row.stock !== ''
          ? Number(row.stock)
          : 0
        ,
        id_ubicacion: row.id_ubicacion ?? '',
        id_proveedor: row.id_proveedor ?? '',
        id_rubro: row.id_rubro ?? '',
        codigo_uni_medida: row.codigo_uni_medida ?? '',
        id_tasa_iva: row.id_tasa_iva ?? '',
        punto_pedido: parseFloat(row.punto_pedido) || 0,
        bonif: parseFloat(row.bonif) || 0,
        obsv: row.obsv ?? '',
      }));

      console.log('Stock final:', sanitizedData.map(r => r.stock));


      setArticulos(sanitizedData);
    } catch (err) {
      console.error("Error al cargar artículos:", err);
      setError(err.message || "Error al cargar los artículos");
    } finally {
      setLoading(false);
    }
  }, []);


  return (
    <ArticulosContext.Provider
      value={{ articulos, loading, error, fetchArticulos }}
    >
      {children}
    </ArticulosContext.Provider>
  );
};

// Hook personalizado para consumir el contexto
export const useArticulos = () => {
  const context = useContext(ArticulosContext);
  if (!context) {
    throw new Error("useArticulos debe usarse dentro de un ArticulosProvider");
  }
  return context;
};

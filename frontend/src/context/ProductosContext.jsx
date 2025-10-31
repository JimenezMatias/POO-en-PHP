// src/context/ProductosContext.jsx
import React, { createContext, useContext, useState, useCallback } from "react";
import { listarArticulos } from "../servicios/articulosService";

const ProductosContext = createContext();

export const ProductosProvider = ({ children }) => {
  const [productos, setProductos] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const fetchProductos = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const data = await listarArticulos();
      
      setProductos(data);
    } catch (err) {
      console.error("Error al cargar productos:", err);
      setError(err.message || "Error al cargar los productos");
    } finally {
      setLoading(false);
    }
  }, []);

  // Nueva función para agregar un producto dinámicamente
  const agregarProducto = useCallback((nuevoProducto) => {
    setProductos(prev => [...prev, nuevoProducto]);
  }, []);

  // Actualizar
  const actualizarProducto = useCallback((productoActualizado) => {
    setProductos(prev =>
      prev.map(p =>
        p.codigo === productoActualizado.codigo ? productoActualizado : p
      )
    );
  }, []);

  // Eliminar
  const eliminarProducto = useCallback((codigo) => {
    setProductos(prev => prev.filter(p => p.codigo !== codigo));
  }, []);

  return (
    <ProductosContext.Provider
      value={{ productos, loading, error, fetchProductos, agregarProducto, actualizarProducto, eliminarProducto }}
    >
      {children}
    </ProductosContext.Provider>
  );
};

export const useProductos = () => {
  const context = useContext(ProductosContext);
  if (!context) {
    throw new Error("useProductos debe usarse dentro de un ProductosProvider");
  }
  return context;
};

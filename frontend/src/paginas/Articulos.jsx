// src/pages/Articulos.jsx
import React, { useEffect } from 'react';
import { DataGrid } from '@mui/x-data-grid';
import { Box, CircularProgress, Typography } from '@mui/material';
import { useArticulos } from '../context/ArticulosContext';

// Helper para formatear números
const formatNumber = (value, decimals = 2) => {
  if (value === null || value === undefined || value === '') {
    return decimals === 4 ? '0.0000' : '0.00';
  }

  const n = Number(value);
  return isNaN(n) ? (decimals === 4 ? '0.0000' : '0.00') : n.toFixed(decimals);
};





// Columnas con ancho fijo
const columns = [
  { field: 'codigo', headerName: 'Código', width: 150 },
  { field: 'detalle', headerName: 'Detalle',  width: 150 },
  { field: 'costo',
    headerName: 'Costo',
    width: 120, valueFormatter: (params) => formatNumber(params.value) },
  { field: 'porcen', headerName: '%',  width: 100, valueFormatter: (params) => formatNumber(params.value) },
  { field: 'precio_venta', headerName: 'Precio Venta',  width: 120, valueFormatter: (params) => formatNumber(params.value) },
  {
    field: 'stock',
    headerName: 'Stock',
    width: 120,
    valueGetter: (params) => {
      const val = params.row?.stock;
      console.log('Getter stock:', val);
      return val ?? 0;
    },
    valueFormatter: (params) => {
      console.log('Formatter stock:', params.value);
      return formatNumber(params.value, 4);
    },
    renderCell: (params) => {
      const formatted = formatNumber(params.row?.stock, 4);
      console.log('RenderCell stock:', formatted);
      return <strong>{formatted}</strong>;
    }

  },
  { field: 'id_ubicacion', headerName: 'Ubicación',  width: 120 },
  { field: 'id_proveedor', headerName: 'Proveedor',  width: 120 },
  { field: 'id_rubro', headerName: 'Rubro',  width: 120 },
  { field: 'codigo_uni_medida', headerName: 'Unidad Medida',  width: 140 },
  { field: 'id_tasa_iva', headerName: 'Tasa IVA',  width: 120 },
  { field: 'punto_pedido', headerName: 'Punto Pedido',  width: 120, valueFormatter: (params) => formatNumber(params.value) },
  { field: 'bonif', headerName: 'Bonificación',  width: 120, valueFormatter: (params) => formatNumber(params.value) },
  { field: 'obsv', headerName: 'Observaciones',  width: 170 },
];

export default function Articulos() {
  
  const { articulos, loading, error, fetchArticulos } = useArticulos();

  

  useEffect(() => {
    fetchArticulos();
  }, [fetchArticulos]);

  return (
  <Box p={2} sx={{ height: 'calc(100vh - 120px)', display: 'flex', flexDirection: 'column' }}>
    {/* Loader central */}
    {loading && (
      <Box display="flex" alignItems="center" justifyContent="center" flexGrow={1}>
        <CircularProgress />
      </Box>
    )}

    {/* Error */}
    {error && (
      <Typography color="error" mb={2}>
        {error}
      </Typography>
    )}

    {/* DataGrid */}
    {!loading && (
      <Box sx={{ }}>
        <DataGrid
          rows={articulos}
          columns={columns}
          getRowId={(row) => row.codigo}
          pageSizeOptions={[25, 50, 100]}
          pagination
          disableRowSelectionOnClick
          sx={{
            flexGrow: 1,
            '& .MuiDataGrid-columnHeaders': {
              backgroundColor: '#f5f5f5',
            },
          }}
        />
      </Box>
    )}
  </Box>

  );
}

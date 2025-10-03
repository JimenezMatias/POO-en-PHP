// src/pages/Articulos.jsx
import React, { useEffect, useState, useMemo } from 'react';
import { DataGrid } from '@mui/x-data-grid';
import { Box, CircularProgress, Typography, TextField } from '@mui/material';
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
  { field: 'codigo', headerName: 'Código', width: 70 },
  { field: 'detalle', headerName: 'Detalle', width: 150 },
  {
    field: 'costo',
    headerName: 'Costo',
    width: 70,
    valueGetter: (params) => params.row?.costo ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 2),
    renderCell: (params) => <strong>{formatNumber(params.row?.costo ?? 0, 2)}</strong>,
  },
  {
    field: 'porcen',
    headerName: 'Porcentaje',
    width: 100,
    valueGetter: (params) => params.row?.porcen ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 2),
    renderCell: (params) => <strong>{formatNumber(params.row?.porcen ?? 0, 2)}</strong>,
  },
  {
    field: 'precio_venta',
    headerName: 'Precio Venta',
    width: 100,
    valueGetter: (params) => params.row?.precio_venta ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 2),
    renderCell: (params) => <strong>{formatNumber(params.row?.precio_venta ?? 0, 2)}</strong>,
  },
  {
    field: 'stock',
    headerName: 'Stock',
    width: 90,
    valueGetter: (params) => params.row?.stock ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 4),
    renderCell: (params) => <strong>{formatNumber(params.row?.stock ?? 0, 4)}</strong>,
  },
  { field: 'id_ubicacion', headerName: 'Ubicación', width: 90 },
  { field: 'id_proveedor', headerName: 'Proveedor', width: 90 },
  { field: 'id_rubro', headerName: 'Rubro', width: 70 },
  { field: 'codigo_uni_medida', headerName: 'Unidad Medida', width: 120 },
  { field: 'id_tasa_iva', headerName: 'Tasa IVA', width: 90 },
  {
    field: 'punto_pedido',
    headerName: 'Punto Pedido',
    width: 110,
    valueGetter: (params) => params.row?.punto_pedido ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 0),
    renderCell: (params) => <strong>{formatNumber(params.row?.punto_pedido ?? 0, 2)}</strong>,
  },
  {
    field: 'bonif',
    headerName: 'Bonificación',
    width: 100,
    valueGetter: (params) => params.row?.bonif ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 2),
    renderCell: (params) => <strong>{formatNumber(params.row?.bonif ?? 0, 2)}</strong>,
  },
  { field: 'obsv', headerName: 'Observaciones', width: 150 },
];

export default function Articulos() {
  const { articulos, loading, error, fetchArticulos } = useArticulos();
  const [search, setSearch] = useState("");

  useEffect(() => {
    fetchArticulos();
  }, [fetchArticulos]);

  // Filtrado en memoria (frontend)
  const filteredRows = useMemo(() => {
    if (!search) return articulos;
    return articulos.filter((art) =>
      art.detalle?.toLowerCase().includes(search.toLowerCase())
    );
  }, [articulos, search]);

  return (
    <Box p={2} sx={{ height: 'calc(100vh - 120px)', display: 'flex', flexDirection: 'column' }}>
      {/* Loader */}
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

      {/* DataGrid + Buscador */}
      {!loading && (
        <Box sx={{ flexGrow: 1, display: "flex", flexDirection: "column" }}>
          <TextField
            label="Buscar artículo por nombre"
            variant="outlined"
            size="small"
            fullWidth
            sx={{ mb: 2 }}
            value={search}
            onChange={(e) => setSearch(e.target.value)}
          />
          <DataGrid
            rows={filteredRows}
            columns={columns}
            getRowId={(row) => row.codigo}
            initialState={{
              pagination: {
                paginationModel: {
                  pageSize: 15,
                },
              },
            }}
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

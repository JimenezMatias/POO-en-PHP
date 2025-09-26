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
  { field: 'codigo', headerName: 'Código', width: 70 },
  { field: 'detalle', headerName: 'Detalle', width: 150 },

  {
    field: 'costo',
    headerName: 'Costo',
    width: 70,
    valueGetter: (params) => {
      const val = params.row?.costo;
      console.log('Getter costo:', val);
      return val ?? 0;
    },
    valueFormatter: (params) => {
      console.log('Formatter costo:', params.value);
      return formatNumber(params.value, 2);
    },
    renderCell: (params) => {
      const formatted = formatNumber(params.row?.costo ?? 0, 2);
      console.log('RenderCell costo:', formatted);
      return <strong>{formatted}</strong>;
    }
  },

  {
    field: 'porcen',
    headerName: 'Porcentaje',
    width: 100,
    valueGetter: (params) => {
      const val = params.row?.porcen;
      console.log('Getter porcen:', val);
      return val ?? 0;
    },
    valueFormatter: (params) => {
      console.log('Formatter porcen:', params.value);
      return formatNumber(params.value, 2);
    },
    renderCell: (params) => {
      const formatted = formatNumber(params.row?.porcen ?? 0, 2);
      console.log('RenderCell porcen:', formatted);
      return <strong>{formatted}</strong>;
    }
  },

  {
    field: 'precio_venta',
    headerName: 'Precio Venta',
    width: 100,
    valueGetter: (params) => {
      const val = params.row?.precio_venta;
      console.log('Getter precio_venta:', val);
      return val ?? 0;
    },
    valueFormatter: (params) => {
      console.log('Formatter precio_venta:', params.value);
      return formatNumber(params.value, 2);
    },
    renderCell: (params) => {
      const formatted = formatNumber(params.row?.precio_venta ?? 0, 2);
      console.log('RenderCell precio_venta:', formatted);
      return <strong>{formatted}</strong>;
    }
  },

  {
    field: 'stock',
    headerName: 'Stock',
    width: 90,
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

  { field: 'id_ubicacion', headerName: 'Ubicación', width: 90 },
  { field: 'id_proveedor', headerName: 'Proveedor', width: 90 },
  { field: 'id_rubro', headerName: 'Rubro', width: 70 },
  { field: 'codigo_uni_medida', headerName: 'Unidad Medida', width: 120 },
  { field: 'id_tasa_iva', headerName: 'Tasa IVA', width: 90 },

  {
    field: 'punto_pedido',
    headerName: 'Punto Pedido',
    width: 110,
    valueGetter: (params) => {
      const val = params.row?.punto_pedido;
      console.log('Getter punto_pedido:', val);
      return val ?? 0;
    },
    valueFormatter: (params) => {
      console.log('Formatter punto_pedido:', params.value);
      return formatNumber(params.value, 0);
    },
    renderCell: (params) => {
      const formatted = formatNumber(params.row?.punto_pedido ?? 0, 2);
      console.log('RenderCell punto_pedido:', formatted);
      return <strong>{formatted}</strong>;
    }
  },

  {
    field: 'bonif',
    headerName: 'Bonificación',
    width: 100,
    valueGetter: (params) => {
      const val = params.row?.bonif;
      console.log('Getter bonif:', val);
      return val ?? 0;
    },
    valueFormatter: (params) => {
      console.log('Formatter bonif:', params.value);
      return formatNumber(params.value, 2);
    },
    renderCell: (params) => {
      const formatted = formatNumber(params.row?.bonif ?? 0, 2);
      console.log('RenderCell bonif:', formatted);
      return <strong>{formatted}</strong>;
    }
  },
  { field: 'obsv', headerName: 'Observaciones', width: 150 }
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

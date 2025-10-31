// src/pages/Articulos.jsx
import React, { useState, useMemo, useEffect } from 'react';
import { DataGrid } from '@mui/x-data-grid';
import {
  Box,
  CircularProgress,
  Typography,
  FormControl,
  Select,
  MenuItem,
  TextField,
  Button,
  Stack,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
} from "@mui/material";
import { useProductos } from '../context/ProductosContext'; //  nuevo contexto
import {
  crearArticulo,
  actualizarArticulo,
  eliminarArticulo,
} from '../servicios/articulosService';

import { listarUbicaciones as fetchUbicaciones} from '../servicios/ubicacionesService';
import { listarProveedores as fetchProveedores} from '../servicios/proveedoresService';
import { listarRubros as fetchRubros } from '../servicios/rubrosService';
import { listarUnidadesMedida as fetchUnidadesMedida} from '../servicios/unidadesMedidaService';
import { listarTasasIva as fetchTasasIva} from '../servicios/tasasIvaService';

const formatNumber = (value, decimals = 2) => {
  if (value === null || value === undefined || value === '') {
    return decimals === 4 ? '0.0000' : '0.00';
  }
  const n = Number(value);
  return isNaN(n) ? (decimals === 4 ? '0.0000' : '0.00') : n.toFixed(decimals);
};

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
  const { productos, loading, error, fetchProductos } = useProductos();
  useEffect(() => {
    fetchProductos(); //  carga los productos al montar
  }, [fetchProductos]);



  // ✅ Estados base
  const [search, setSearch] = useState("");
  const [openCrear, setOpenCrear] = useState(false);
  const [openActualizar, setOpenActualizar] = useState(false);
  const [openEliminar, setOpenEliminar] = useState(false);

  // ✅ Estados para formularios
  const [form, setForm] = useState({});
  const [busqueda, setBusqueda] = useState("");
  const [seleccionado, setSeleccionado] = useState(null);
  const [rows, setRows] = useState([]);

  //fks
  const [ubicaciones, setUbicaciones] = useState([]);
  const [proveedores, setProveedores] = useState([]);
  const [rubros, setRubros] = useState([]);
  const [unidadesMedida, setUnidadesMedida] = useState([]);
  const [tasasIva, setTasasIva] = useState([]);


  useEffect(() => {
    if (!search) {
      setRows(productos);
    } else {
      setRows(
        productos.filter((art) =>
          art.detalle.toLowerCase().includes(search.toLowerCase())
        )
      );
    }
  }, [productos, search]);

  // ✅ Manejadores generales
  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const normalizarArticulo = (articulo) => ({
    ...articulo,
    codigo: articulo.codigo ? String(articulo.codigo).trim() : undefined,
    detalle: articulo.detalle?.trim() ?? '',
    costo: parseFloat(articulo.costo) || 0,
    porcen: parseFloat(articulo.porcen) || 0,
    precio_venta: parseFloat(articulo.precio_venta) || 0,
    stock: parseFloat(articulo.stock) || 0,
    id_ubicacion: parseInt(articulo.id_ubicacion) || null,
    id_proveedor: parseInt(articulo.id_proveedor) || null,
    id_rubro: parseInt(articulo.id_rubro) || null,
    codigo_uni_medida: parseInt(articulo.codigo_uni_medida) || null,
    id_tasa_iva: parseInt(articulo.id_tasa_iva) || null,
    punto_pedido: parseFloat(articulo.punto_pedido) || 0,
    bonif: parseFloat(articulo.bonif) || 0,
    obsv: articulo.obsv?.trim() ?? '',
  });

  const handleGuardar = async () => {
    try {
      const payload = normalizarArticulo(form);
      await crearArticulo(payload);
      await fetchProductos();
      setOpenCrear(false);
      setForm({});
    } catch (error) {
      console.error('Error al guardar artículo:', error);
    }
  };


  const handleActualizar = async () => {
    if (!seleccionado) return;

    try {
      const payload = normalizarArticulo(form); //  normalizar antes de enviar
      await actualizarArticulo(seleccionado.codigo, payload); // pasar código + payload
      await fetchProductos(); // refrescar grilla
      setOpenActualizar(false);
      setForm({});
      setSeleccionado(null);
    } catch (error) {
      console.error('Error al actualizar artículo:', error);
    }
  };



  const handleEliminar = async () => {
    if (!seleccionado) return;

    try {
      await eliminarArticulo(seleccionado.codigo);
      await fetchProductos(); // refrescar grilla
      setOpenEliminar(false);
      setSeleccionado(null);
    } catch (error) {
      console.error('Error al eliminar artículo:', error);
    }
  };


  // ✅ Filtrado para buscador interno de los dialogs
  const filtradosDialog = useMemo(() => {
    if (!busqueda) return productos;
    return productos.filter((p) =>
      p.detalle.toLowerCase().includes(busqueda.toLowerCase())
    );
  }, [busqueda, productos]);

  // fetchs a fks
  useEffect(() => {
    const fetchFKs = async () => {
      try {
        const [resUbicaciones, resProveedores, resRubros, resUnidades, resTasas] = await Promise.all([
          fetchUbicaciones(),  // desde tu service.js
          fetchProveedores(),
          fetchRubros(),
          fetchUnidadesMedida(),
          fetchTasasIva(),
        ]);

        setUbicaciones(resUbicaciones);
        setProveedores(resProveedores);
        setRubros(resRubros);
        setUnidadesMedida(resUnidades);
        setTasasIva(resTasas);
      } catch (err) {
        console.error("Error cargando FK:", err);
      }
    };

    fetchFKs();
  }, []);


  return (
    <Box
      p={2}
      sx={{
        height: "calc(100vh - 120px)",
        display: "flex",
        flexDirection: "column",
      }}
    >
      {/* LOADING Y ERRORES */}
      {loading && (
        <Box display="flex" alignItems="center" justifyContent="center" flexGrow={1}>
          <CircularProgress />
        </Box>
      )}

      {error && (
        <Typography color="error" mb={2}>
          {error}
        </Typography>
      )}

      {!loading && (
        <Box sx={{ flexGrow: 1, display: "flex", flexDirection: "column" }}>
          <Stack direction="row" spacing={2} mb={2}>
            <Button variant="contained" color="primary" onClick={() => setOpenCrear(true)}>
              Crear Producto
            </Button>
            <Button variant="contained" color="success" onClick={() => setOpenActualizar(true)}>
              Actualizar Producto
            </Button>
            <Button variant="contained" color="error" onClick={() => setOpenEliminar(true)}>
              Eliminar Producto
            </Button>
          </Stack>

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
            rows={rows}
            columns={columns}
            getRowId={(row) => row.codigo}
            initialState={{
              pagination: { paginationModel: { pageSize: 15 } },
            }}
            pagination
            disableRowSelectionOnClick
            sx={{
              flexGrow: 1,
              "& .MuiDataGrid-columnHeaders": { backgroundColor: "#f5f5f5" },
            }}
          />
        </Box>
      )}

      {/* 🟢 DIALOG CREAR */}
      <Dialog open={openCrear} onClose={() => setOpenCrear(false)} maxWidth="sm" fullWidth>
        <DialogTitle>Crear nuevo producto</DialogTitle>
        <DialogContent dividers>
          <Stack spacing={2}>
            <TextField name="codigo" label="Codigo" onChange={handleChange} fullWidth />
            <TextField name="detalle" label="Detalle" onChange={handleChange} fullWidth />
            <TextField name="costo" label="Costo" onChange={handleChange} fullWidth />
            <TextField name="porcen" label="Porcentaje" onChange={handleChange} fullWidth />
            <TextField name="precio_venta" label="Precio Venta" onChange={handleChange} fullWidth />
            <TextField name="stock" label="Stock" onChange={handleChange} fullWidth />
            
            <FormControl fullWidth> 
                <Select
                  value={form.id_ubicacion || ""}
                  onChange={(e) => setForm({ ...form, id_ubicacion: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Ubicación</span>;
                    const ubic = ubicaciones.find(u => u.id_ubicacion === selected);
                    return ubic ? (
                      <span>
                        <span style={{ color: "#555" }}>Ubicación: </span>
                        <span style={{ color: "#000" }}>{ubic.desc_ubicacion}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {ubicaciones.map(u => (
                    <MenuItem key={u.id_ubicacion} value={u.id_ubicacion}>
                      {u.desc_ubicacion}
                    </MenuItem>
                  ))}
                </Select>
            </FormControl>

            {/* Proveedor */}
              <FormControl fullWidth>
                <Select
                  value={form.id_proveedor || ""}
                  onChange={(e) => setForm({ ...form, id_proveedor: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Proveedor</span>;
                    const prov = proveedores.find(p => p.id_proveedor === selected);
                    return prov ? (
                      <span>
                        <span style={{ color: "#555" }}>Proveedor: </span>
                        <span style={{ color: "#000" }}>{prov.razon_social}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {proveedores.map(p => (
                    <MenuItem key={p.id_proveedor} value={p.id_proveedor}>
                      {p.razon_social}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Rubro */}
              <FormControl fullWidth>
                <Select
                  value={form.id_rubro || ""}
                  onChange={(e) => setForm({ ...form, id_rubro: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Rubro</span>;
                    const rubro = rubros.find(r => r.id_rubro === selected);
                    return rubro ? (
                      <span>
                        <span style={{ color: "#555" }}>Rubro: </span>
                        <span style={{ color: "#000" }}>{rubro.desc_rubro}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {rubros.map(r => (
                    <MenuItem key={r.id_rubro} value={r.id_rubro}>
                      {r.desc_rubro}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Unidad de Medida */}
              <FormControl fullWidth>
                <Select
                  value={form.codigo_uni_medida || ""}
                  onChange={(e) => setForm({ ...form, codigo_uni_medida: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Unidad de Medida</span>;
                    const unidad = unidadesMedida.find(u => u.codigo_uni_medida === selected);
                    return unidad ? (
                      <span>
                        <span style={{ color: "#555" }}>Unidad Medida: </span>
                        <span style={{ color: "#000" }}>{unidad.descripcion_uni_medida}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {unidadesMedida.map(u => (
                    <MenuItem key={u.codigo_uni_medida} value={u.codigo_uni_medida}>
                      {u.descripcion_uni_medida}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Tasa IVA */}
              <FormControl fullWidth>
                <Select
                  value={form.id_tasa_iva || ""}
                  onChange={(e) => setForm({ ...form, id_tasa_iva: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Tasa IVA</span>;
                    const tasa = tasasIva.find(t => t.id_tasa_iva === selected);
                    return tasa ? (
                      <span>
                        <span style={{ color: "#555" }}>Tasa IVA: </span>
                        <span style={{ color: "#000" }}>{tasa.descrip_tasa_iva}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {tasasIva.map(t => (
                    <MenuItem key={t.id_tasa_iva} value={t.id_tasa_iva}>
                      {t.descrip_tasa_iva}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            <TextField name="punto_pedido" label="Punto Pedido" onChange={handleChange} fullWidth />
            <TextField name="bonif" label="Bonificación" onChange={handleChange} fullWidth />
            <TextField name="obsv" label="Observaciones" onChange={handleChange} fullWidth />
          </Stack>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpenCrear(false)}>Cancelar</Button>
          <Button variant="contained" color="primary" onClick={handleGuardar}>
            Guardar
          </Button>
        </DialogActions>
      </Dialog>

      {/* 🟠 DIALOG ACTUALIZAR */}
      <Dialog open={openActualizar} onClose={() => setOpenActualizar(false)} maxWidth="sm" fullWidth>
        <DialogTitle>Actualizar producto existente</DialogTitle>
        <DialogContent dividers>
          {!seleccionado ? (
            <>
              <TextField
                label="Buscar producto"
                variant="outlined"
                fullWidth
                sx={{ mb: 2 }}
                value={busqueda}
                onChange={(e) => setBusqueda(e.target.value)}
              />
              {filtradosDialog.slice(0, 5).map((p) => (
                <Box
                  key={p.codigo}
                  sx={{
                    p: 1,
                    border: "1px solid #ccc",
                    borderRadius: 1,
                    mb: 1,
                    cursor: "pointer",
                    "&:hover": { backgroundColor: "#f5f5f5" },
                  }}
                  onClick={() => {
                    setSeleccionado(p);
                    setForm(p);
                  }}
                >
                  <Typography>{p.detalle}</Typography>
                </Box>
              ))}
            </>
          ) : (
            <Stack spacing={2}>
              <TextField name="codigo" label="Codigo" value={form.codigo || ""} onChange={handleChange} fullWidth disabled />
              <TextField name="detalle" label="Detalle" value={form.detalle || ""} onChange={handleChange} fullWidth />
              <TextField name="costo" label="Costo" value={form.costo || ""} onChange={handleChange} fullWidth />
              <TextField name="porcen" label="Porcentaje" value={form.porcen || ""} onChange={handleChange} fullWidth />
              <TextField name="precio_venta" label="Precio Venta" value={form.precio_venta || ""} onChange={handleChange} fullWidth />
              <TextField name="stock" label="Stock" value={form.stock || ""} onChange={handleChange} fullWidth />
              {/* Ubicación */}
              <FormControl fullWidth> 
                <Select
                  value={form.id_ubicacion || ""}
                  onChange={(e) => setForm({ ...form, id_ubicacion: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Ubicación</span>;
                    const ubic = ubicaciones.find(u => u.id_ubicacion === selected);
                    return ubic ? (
                      <span>
                        <span style={{ color: "#555" }}>Ubicación: </span>
                        <span style={{ color: "#000" }}>{ubic.desc_ubicacion}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {ubicaciones.map(u => (
                    <MenuItem key={u.id_ubicacion} value={u.id_ubicacion}>
                      {u.desc_ubicacion}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Proveedor */}
              <FormControl fullWidth>
                <Select
                  value={form.id_proveedor || ""}
                  onChange={(e) => setForm({ ...form, id_proveedor: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Proveedor</span>;
                    const prov = proveedores.find(p => p.id_proveedor === selected);
                    return prov ? (
                      <span>
                        <span style={{ color: "#555" }}>Proveedor: </span>
                        <span style={{ color: "#000" }}>{prov.razon_social}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {proveedores.map(p => (
                    <MenuItem key={p.id_proveedor} value={p.id_proveedor}>
                      {p.razon_social}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Rubro */}
              <FormControl fullWidth>
                <Select
                  value={form.id_rubro || ""}
                  onChange={(e) => setForm({ ...form, id_rubro: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Rubro</span>;
                    const rubro = rubros.find(r => r.id_rubro === selected);
                    return rubro ? (
                      <span>
                        <span style={{ color: "#555" }}>Rubro: </span>
                        <span style={{ color: "#000" }}>{rubro.desc_rubro}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {rubros.map(r => (
                    <MenuItem key={r.id_rubro} value={r.id_rubro}>
                      {r.desc_rubro}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Unidad de Medida */}
              <FormControl fullWidth>
                <Select
                  value={form.codigo_uni_medida || ""}
                  onChange={(e) => setForm({ ...form, codigo_uni_medida: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Unidad de Medida</span>;
                    const unidad = unidadesMedida.find(u => u.codigo_uni_medida === selected);
                    return unidad ? (
                      <span>
                        <span style={{ color: "#555" }}>Unidad Medida: </span>
                        <span style={{ color: "#000" }}>{unidad.descripcion_uni_medida}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {unidadesMedida.map(u => (
                    <MenuItem key={u.codigo_uni_medida} value={u.codigo_uni_medida}>
                      {u.descripcion_uni_medida}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Tasa IVA */}
              <FormControl fullWidth>
                <Select
                  value={form.id_tasa_iva || ""}
                  onChange={(e) => setForm({ ...form, id_tasa_iva: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Tasa IVA</span>;
                    const tasa = tasasIva.find(t => t.id_tasa_iva === selected);
                    return tasa ? (
                      <span>
                        <span style={{ color: "#555" }}>Tasa IVA: </span>
                        <span style={{ color: "#000" }}>{tasa.descrip_tasa_iva}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {tasasIva.map(t => (
                    <MenuItem key={t.id_tasa_iva} value={t.id_tasa_iva}>
                      {t.descrip_tasa_iva}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
              <TextField name="punto_pedido" label="Punto Pedido" value={form.punto_pedido || ""} onChange={handleChange} fullWidth />
              <TextField name="bonif" label="Bonificacion" value={form.bonif || ""} onChange={handleChange} fullWidth />
              <TextField name="obsv" label="Observaciones" value={form.obsv || ""} onChange={handleChange} fullWidth />
              
            </Stack>
          )}
        </DialogContent>
        <DialogActions>
          <Button
            onClick={() => {
              setOpenActualizar(false);
              setSeleccionado(null);
            }}
          >
            Cancelar
          </Button>
          {seleccionado && (
            <Button variant="contained" color="warning" onClick={handleActualizar}>
              Actualizar
            </Button>
          )}
        </DialogActions>
      </Dialog>

      {/* 🔴 DIALOG ELIMINAR */}
      <Dialog open={openEliminar} onClose={() => setOpenEliminar(false)} maxWidth="sm" fullWidth>
        <DialogTitle>Eliminar producto</DialogTitle>
        <DialogContent dividers>
          {!seleccionado ? (
            <>
              <TextField
                label="Buscar producto"
                variant="outlined"
                fullWidth
                sx={{ mb: 2 }}
                value={busqueda}
                onChange={(e) => setBusqueda(e.target.value)}
              />
              {filtradosDialog.slice(0, 5).map((p) => (
                <Box
                  key={p.codigo}
                  sx={{
                    p: 1,
                    border: "1px solid #ccc",
                    borderRadius: 1,
                    mb: 1,
                    cursor: "pointer",
                    "&:hover": { backgroundColor: "#f5f5f5" },
                  }}
                  onClick={() => setSeleccionado(p)}
                >
                  <Typography>{p.detalle}</Typography>
                </Box>
              ))}
            </>
          ) : (
            <Typography>
              ¿Seguro que deseas eliminar el producto <b>{seleccionado.detalle}</b> (Código: {seleccionado.codigo})?
            </Typography>
          )}
        </DialogContent>
        <DialogActions>
          <Button
            onClick={() => {
              setOpenEliminar(false);
              setSeleccionado(null);
            }}
          >
            Cancelar
          </Button>
          {seleccionado && (
            <Button variant="contained" color="error" onClick={handleEliminar}>
              Eliminar
            </Button>
          )}
        </DialogActions>
      </Dialog>
    </Box>
  );
}
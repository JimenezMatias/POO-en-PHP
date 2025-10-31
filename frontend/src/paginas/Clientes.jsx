// src/pages/Clientes.jsx
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

import {
  listarClientes,
  crearCliente,
  editarCliente,
  eliminarCliente,
} from '../servicios/clientesService';

import { listarLocalidades } from '../servicios/localidadesService';
import { listarRespIva } from '../servicios/respIvaService';
import { listarTiposDoc } from '../servicios/tiposDocService';
import { listarTiposDocAfip } from '../servicios/tiposDocAfipService';

const formatNumber = (value, decimals = 2) => {
  if (value === null || value === undefined || value === '') {
    return '0.00';
  }
  const n = Number(value);
  return isNaN(n) ? '0.00' : n.toFixed(decimals);
};

const columns = [
  { field: 'id_cliente', headerName: 'ID', width: 70 },
  { field: 'razon_social', headerName: 'Razón Social', width: 250 },
  { field: 'domicilio', headerName: 'Domicilio', width: 200 },
  { field: 'cp', headerName: 'CP', width: 90 },
  { field: 'nro_doc', headerName: 'Nro. Documento', width: 130 },
  { field: 'iva', headerName: 'Condición IVA', width: 150 },
  { field: 'tipo_doc', headerName: 'Tipo Doc', width: 120 },
  { field: 'tipo_doc_afip', headerName: 'Tipo Doc AFIP', width: 130 },
  {
    field: 'limite_cc',
    headerName: 'Límite CC',
    width: 110,
    valueGetter: (params) => params.row?.limite_cc ?? 0,
    valueFormatter: (params) => formatNumber(params.value, 2),
    renderCell: (params) => <strong>{formatNumber(params.row?.limite_cc ?? 0, 2)}</strong>,
  },
];

export default function Clientes() {
  // Estados base
  const [clientes, setClientes] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [search, setSearch] = useState("");
  const [openCrear, setOpenCrear] = useState(false);
  const [openActualizar, setOpenActualizar] = useState(false);
  const [openEliminar, setOpenEliminar] = useState(false);

  // Estados para formularios
  const [form, setForm] = useState({});
  const [busqueda, setBusqueda] = useState("");
  const [seleccionado, setSeleccionado] = useState(null);
  const [rows, setRows] = useState([]);

  // Estados para FK
  const [localidades, setLocalidades] = useState([]);
  const [respIva, setRespIva] = useState([]);
  const [tiposDoc, setTiposDoc] = useState([]);
  const [tiposDocAfip, setTiposDocAfip] = useState([]);

  // Cargar clientes inicial
  const fetchClientes = async () => {
    setLoading(true);
    setError(null);
    try {
      const data = await listarClientes();
      setClientes(data);
    } catch (err) {
      setError(err.message);
      console.error('Error al cargar clientes:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchClientes();
  }, []);

  // Filtrar clientes por búsqueda
  useEffect(() => {
    if (!search) {
      setRows(clientes);
    } else {
      setRows(
        clientes.filter((cli) =>
          cli.razon_social.toLowerCase().includes(search.toLowerCase())
        )
      );
    }
  }, [clientes, search]);

  // Cargar FKs
  useEffect(() => {
    const fetchFKs = async () => {
      try {
        const [resLocalidades, resRespIva, resTiposDoc, resTiposDocAfip] = await Promise.all([
          listarLocalidades(),
          listarRespIva(),
          listarTiposDoc(),
          listarTiposDocAfip(),
        ]);

        setLocalidades(resLocalidades);
        setRespIva(resRespIva);
        setTiposDoc(resTiposDoc);
        setTiposDocAfip(resTiposDocAfip);
      } catch (err) {
        console.error("Error cargando FK:", err);
      }
    };

    fetchFKs();
  }, []);

  // Manejadores generales
  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const normalizarCliente = (cliente) => ({
    razon_social: cliente.razon_social?.trim() ?? '',
    domicilio: cliente.domicilio?.trim() ?? '',
    cp: parseInt(cliente.cp) || null,
    id_tipo_doc: parseInt(cliente.id_tipo_doc) || null,
    nro_doc: cliente.nro_doc?.trim() ?? '',
    id_resp_iva: parseInt(cliente.id_resp_iva) || null,
    id_tipo_doc_afip: parseFloat(cliente.id_tipo_doc_afip) || null,
    limite_cc: parseFloat(cliente.limite_cc) || 0,
  });

  const handleGuardar = async () => {
    try {
      const payload = normalizarCliente(form);
      await crearCliente(payload);
      await fetchClientes();
      setOpenCrear(false);
      setForm({});
    } catch (error) {
      console.error('Error al guardar cliente:', error);
      alert('Error al guardar cliente: ' + error.message);
    }
  };

  const handleActualizar = async () => {
    if (!seleccionado) return;

    try {
      const payload = normalizarCliente(form);
      await editarCliente(seleccionado.id_cliente, payload);
      await fetchClientes();
      setOpenActualizar(false);
      setForm({});
      setSeleccionado(null);
    } catch (error) {
      console.error('Error al actualizar cliente:', error);
      alert('Error al actualizar cliente: ' + error.message);
    }
  };

  const handleEliminar = async () => {
    if (!seleccionado) return;

    try {
      await eliminarCliente(seleccionado.id_cliente);
      await fetchClientes();
      setOpenEliminar(false);
      setSeleccionado(null);
    } catch (error) {
      console.error('Error al eliminar cliente:', error);
      alert('Error al eliminar cliente: ' + error.message);
    }
  };

  // Filtrado para buscador interno de los dialogs
  const filtradosDialog = useMemo(() => {
    if (!busqueda) return clientes;
    return clientes.filter((c) =>
      c.razon_social.toLowerCase().includes(busqueda.toLowerCase())
    );
  }, [busqueda, clientes]);

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
              Crear Cliente
            </Button>
            <Button variant="contained" color="success" onClick={() => setOpenActualizar(true)}>
              Actualizar Cliente
            </Button>
            <Button variant="contained" color="error" onClick={() => setOpenEliminar(true)}>
              Eliminar Cliente
            </Button>
          </Stack>

          <TextField
            label="Buscar cliente por razón social"
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
            getRowId={(row) => row.id_cliente}
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
        <DialogTitle>Crear nuevo cliente</DialogTitle>
        <DialogContent dividers>
          <Stack spacing={2}>
            <TextField name="razon_social" label="Razón Social" onChange={handleChange} fullWidth required />
            <TextField name="domicilio" label="Domicilio" onChange={handleChange} fullWidth />
            <TextField name="nro_doc" label="Nro. Documento" onChange={handleChange} fullWidth />
            
            {/* Localidad (CP) */}
            <FormControl fullWidth>
              <Select
                value={form.cp || ""}
                onChange={(e) => setForm({ ...form, cp: e.target.value })}
                displayEmpty
                renderValue={(selected) => {
                  if (!selected) return <span style={{ color: "#aaa" }}>Localidad</span>;
                  const loc = localidades.find(l => Number(l.cp) === Number(selected));
                  return loc ? (
                    <span>
                      <span style={{ color: "#555" }}>Localidad: </span>
                      <span style={{ color: "#000" }}>{loc.localidad}</span>
                    </span>
                  ) : "";
                }}
              >
                {localidades.map(l => (
                  <MenuItem key={l.cp} value={l.cp}>
                    {l.localidad} (CP: {l.cp})
                  </MenuItem>
                ))}
              </Select>
            </FormControl>

            {/* Tipo de Documento */}
            <FormControl fullWidth>
              <Select
                value={form.id_tipo_doc || ""}
                onChange={(e) => setForm({ ...form, id_tipo_doc: e.target.value })}
                displayEmpty
                renderValue={(selected) => {
                  if (!selected) return <span style={{ color: "#aaa" }}>Tipo de Documento</span>;
                  const td = tiposDoc.find(t => Number(t.id_tipo_doc) === Number(selected));
                  return td ? (
                    <span>
                      <span style={{ color: "#555" }}>Tipo Doc: </span>
                      <span style={{ color: "#000" }}>{td.descrip_tipo_doc}</span>
                    </span>
                  ) : "";
                }}
              >
                {tiposDoc.map(t => (
                  <MenuItem key={t.id_tipo_doc} value={t.id_tipo_doc}>
                    {t.descrip_tipo_doc}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>

            {/* Responsabilidad IVA */}
            <FormControl fullWidth>
              <Select
                value={form.id_resp_iva || ""}
                onChange={(e) => setForm({ ...form, id_resp_iva: e.target.value })}
                displayEmpty
                renderValue={(selected) => {
                  if (!selected) return <span style={{ color: "#aaa" }}>Condición IVA</span>;
                  const ri = respIva.find(r => Number(r.id_resp_iva) === Number(selected));
                  return ri ? (
                    <span>
                      <span style={{ color: "#555" }}>Cond. IVA: </span>
                      <span style={{ color: "#000" }}>{ri.descrip_resp_iva}</span>
                    </span>
                  ) : "";
                }}
              >
                {respIva.map(r => (
                  <MenuItem key={r.id_resp_iva} value={r.id_resp_iva}>
                    {r.descrip_resp_iva}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>

            {/* Tipo de Documento AFIP */}
            <FormControl fullWidth>
              <Select
                value={form.id_tipo_doc_afip || ""}
                onChange={(e) => setForm({ ...form, id_tipo_doc_afip: e.target.value })}
                displayEmpty
                renderValue={(selected) => {
                  if (!selected) return <span style={{ color: "#aaa" }}>Tipo Doc AFIP</span>;
                  const tda = tiposDocAfip.find(t => Number(t.id_tipo_doc_afip) === Number(selected));
                  return tda ? (
                    <span>
                      <span style={{ color: "#555" }}>Tipo Doc AFIP: </span>
                      <span style={{ color: "#000" }}>{tda.descrip_tipo_doc_afip}</span>
                    </span>
                  ) : "";
                }}
              >
                {tiposDocAfip.map(t => (
                  <MenuItem key={t.id_tipo_doc_afip} value={t.id_tipo_doc_afip}>
                    {t.descrip_tipo_doc_afip}
                  </MenuItem>
                ))}
              </Select>
            </FormControl>

            <TextField name="limite_cc" label="Límite Cuenta Corriente" onChange={handleChange} fullWidth type="number" />
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
        <DialogTitle>Actualizar cliente existente</DialogTitle>
        <DialogContent dividers>
          {!seleccionado ? (
            <>
              <TextField
                label="Buscar cliente"
                variant="outlined"
                fullWidth
                sx={{ mb: 2 }}
                value={busqueda}
                onChange={(e) => setBusqueda(e.target.value)}
              />
              {filtradosDialog.slice(0, 5).map((c) => (
                <Box
                  key={c.id_cliente}
                  sx={{
                    p: 1,
                    border: "1px solid #ccc",
                    borderRadius: 1,
                    mb: 1,
                    cursor: "pointer",
                    "&:hover": { backgroundColor: "#f5f5f5" },
                  }}
                  onClick={() => {
                    setSeleccionado(c);
                    setForm(c);
                  }}
                >
                  <Typography>{c.razon_social}</Typography>
                </Box>
              ))}
            </>
          ) : (
            <Stack spacing={2}>
              <TextField name="razon_social" label="Razón Social" value={form.razon_social || ""} onChange={handleChange} fullWidth required />
              <TextField name="domicilio" label="Domicilio" value={form.domicilio || ""} onChange={handleChange} fullWidth />
              <TextField name="nro_doc" label="Nro. Documento" value={form.nro_doc || ""} onChange={handleChange} fullWidth />
              
              {/* Localidad (CP) */}
              <FormControl fullWidth>
                <Select
                  value={form.cp || ""}
                  onChange={(e) => setForm({ ...form, cp: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Localidad</span>;
                    const loc = localidades.find(l => Number(l.cp) === Number(selected));
                    return loc ? (
                      <span>
                        <span style={{ color: "#555" }}>Localidad: </span>
                        <span style={{ color: "#000" }}>{loc.localidad}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {localidades.map(l => (
                    <MenuItem key={l.cp} value={l.cp}>
                      {l.localidad} (CP: {l.cp})
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Tipo de Documento */}
              <FormControl fullWidth>
                <Select
                  value={form.id_tipo_doc || ""}
                  onChange={(e) => setForm({ ...form, id_tipo_doc: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Tipo de Documento</span>;
                    const td = tiposDoc.find(t => Number(t.id_tipo_doc) === Number(selected));
                    return td ? (
                      <span>
                        <span style={{ color: "#555" }}>Tipo Doc: </span>
                        <span style={{ color: "#000" }}>{td.descrip_tipo_doc}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {tiposDoc.map(t => (
                    <MenuItem key={t.id_tipo_doc} value={t.id_tipo_doc}>
                      {t.descrip_tipo_doc}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Responsabilidad IVA */}
              <FormControl fullWidth>
                <Select
                  value={form.id_resp_iva || ""}
                  onChange={(e) => setForm({ ...form, id_resp_iva: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Condición IVA</span>;
                    const ri = respIva.find(r => Number(r.id_resp_iva) === Number(selected));
                    return ri ? (
                      <span>
                        <span style={{ color: "#555" }}>Cond. IVA: </span>
                        <span style={{ color: "#000" }}>{ri.descrip_resp_iva}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {respIva.map(r => (
                    <MenuItem key={r.id_resp_iva} value={r.id_resp_iva}>
                      {r.descrip_resp_iva}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              {/* Tipo de Documento AFIP */}
              <FormControl fullWidth>
                <Select
                  value={form.id_tipo_doc_afip || ""}
                  onChange={(e) => setForm({ ...form, id_tipo_doc_afip: e.target.value })}
                  displayEmpty
                  renderValue={(selected) => {
                    if (!selected) return <span style={{ color: "#aaa" }}>Tipo Doc AFIP</span>;
                    const tda = tiposDocAfip.find(t => Number(t.id_tipo_doc_afip) === Number(selected));
                    return tda ? (
                      <span>
                        <span style={{ color: "#555" }}>Tipo Doc AFIP: </span>
                        <span style={{ color: "#000" }}>{tda.descrip_tipo_doc_afip}</span>
                      </span>
                    ) : "";
                  }}
                >
                  {tiposDocAfip.map(t => (
                    <MenuItem key={t.id_tipo_doc_afip} value={t.id_tipo_doc_afip}>
                      {t.descrip_tipo_doc_afip}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>

              <TextField name="limite_cc" label="Límite Cuenta Corriente" value={form.limite_cc || ""} onChange={handleChange} fullWidth type="number" />
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
        <DialogTitle>Eliminar cliente</DialogTitle>
        <DialogContent dividers>
          {!seleccionado ? (
            <>
              <TextField
                label="Buscar cliente"
                variant="outlined"
                fullWidth
                sx={{ mb: 2 }}
                value={busqueda}
                onChange={(e) => setBusqueda(e.target.value)}
              />
              {filtradosDialog.slice(0, 5).map((c) => (
                <Box
                  key={c.id_cliente}
                  sx={{
                    p: 1,
                    border: "1px solid #ccc",
                    borderRadius: 1,
                    mb: 1,
                    cursor: "pointer",
                    "&:hover": { backgroundColor: "#f5f5f5" },
                  }}
                  onClick={() => setSeleccionado(c)}
                >
                  <Typography>{c.razon_social}</Typography>
                </Box>
              ))}
            </>
          ) : (
            <Typography>
              ¿Seguro que deseas eliminar el cliente <b>{seleccionado.razon_social}</b> (ID: {seleccionado.id_cliente})?
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


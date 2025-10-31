import React, { useState, useEffect, useMemo } from "react";
import {
  Box,
  Paper,
  Typography,
  TextField,
  Button,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  Alert,
  Tooltip,
} from "@mui/material";
import { useProductos } from "../context/ProductosContext";
import {
  iniciarVenta as iniciarVentaService,
  actualizarCabecera,
  agregarProducto as agregarProductoService,
  eliminarProducto as eliminarProductoService,
  obtenerDetalle,
  obtenerTotales,
  finalizarVenta as finalizarVentaService,
  cancelarVenta as cancelarVentaService,
} from "../servicios/ventasService";
import { listarClientes } from "../servicios/clientesService";
import { listarFormasDePago } from "../servicios/formaDePagoService";

export default function Ventas() {
  // --- CONTEXT ---
  const { productos, fetchProductos } = useProductos();

  // --- REFS PARA FOCUS ---
  const codigoInputRef = React.useRef(null);

  // --- ESTADOS GENERALES ---
  const [ventaActiva, setVentaActiva] = useState(null);
  const [estadoVenta, setEstadoVenta] = useState("inactiva"); // inactiva | activa | finalizada

  // --- CABECERA ---
  const [clienteSeleccionado, setClienteSeleccionado] = useState(null);
  const [formaPago, setFormaPago] = useState(null);

  // --- DETALLE DE PRODUCTOS ---
  const [detalleVenta, setDetalleVenta] = useState([]);
  const [codigoProducto, setCodigoProducto] = useState("");
  const [cantidadProducto, setCantidadProducto] = useState(1);

  // --- TOTALES (ahora vienen del backend) ---
  const [totales, setTotales] = useState({
    cantidad_productos: 0,
    total_neto: 0,
    iva_10_5: 0,
    iva_21: 0,
    total_final: 0,
  });

  // --- DIALOGS ---
  const [openCliente, setOpenCliente] = useState(false);
  const [openPago, setOpenPago] = useState(false);
  const [openBuscarProducto, setOpenBuscarProducto] = useState(false);
  const [openCalculadora, setOpenCalculadora] = useState(false);
  const [openCtaCte, setOpenCtaCte] = useState(false);

  // --- DATOS PARA DIALOGS ---
  const [clientes, setClientes] = useState([]);
  const [formasPago, setFormasPago] = useState([]);
  const [busquedaCliente, setBusquedaCliente] = useState("");
  const [busquedaPago, setBusquedaPago] = useState("");

  // --- MENSAJES ---
  const [mensaje, setMensaje] = useState("");
  const [tipoMensaje, setTipoMensaje] = useState("info"); // success | error | info

  // --- BUSCADOR DIALOG PRODUCTOS ---
  const [busquedaProductoDialog, setBusquedaProductoDialog] = useState("");

  // --- FILTROS PARA DIALOGS ---
  const productosFiltradosDialog = useMemo(() => {
    if (!busquedaProductoDialog) return productos.slice(0, 5);
    return productos
      .filter((p) =>
        p.detalle.toLowerCase().includes(busquedaProductoDialog.toLowerCase())
      )
      .slice(0, 5);
  }, [busquedaProductoDialog, productos]);

  const clientesFiltrados = useMemo(() => {
    if (!busquedaCliente) return clientes.slice(0, 5);
    return clientes
      .filter((c) =>
        c.razon_social.toLowerCase().includes(busquedaCliente.toLowerCase())
      )
      .slice(0, 5);
  }, [busquedaCliente, clientes]);

  const formasPagoFiltradas = useMemo(() => {
    if (!busquedaPago) return formasPago.slice(0, 5);
    return formasPago
      .filter((f) =>
        f.nombre.toLowerCase().includes(busquedaPago.toLowerCase())
      )
      .slice(0, 5);
  }, [busquedaPago, formasPago]);

  // --- CARGA INICIAL ---
  useEffect(() => {
    fetchProductos();
    cargarClientes();
    cargarFormasPago();
  }, [fetchProductos]);

  const cargarClientes = async () => {
    try {
      const data = await listarClientes();
      setClientes(data);
    } catch (error) {
      console.error("Error al cargar clientes:", error);
    }
  };

  const cargarFormasPago = async () => {
    try {
      const data = await listarFormasDePago();
      setFormasPago(data);
    } catch (error) {
      console.error("Error al cargar formas de pago:", error);
    }
  };

  // --- ACTUALIZAR TOTALES DESDE BACKEND ---
  const actualizarTotales = async (idVenta) => {
    try {
      const data = await obtenerTotales(idVenta);
      setTotales({
        cantidad_productos: data.cantidad_productos || 0,
        total_neto: parseFloat(data.total_neto) || 0,
        iva_10_5: parseFloat(data.iva_10_5) || 0,
        iva_21: parseFloat(data.iva_21) || 0,
        total_final: parseFloat(data.total_final) || 0,
      });
    } catch (error) {
      console.error("Error al actualizar totales:", error);
    }
  };

  // --- ACTUALIZAR DETALLE DESDE BACKEND ---
  const actualizarDetalle = async (idVenta) => {
    try {
      const data = await obtenerDetalle(idVenta);
      setDetalleVenta(data || []);
    } catch (error) {
      console.error("Error al actualizar detalle:", error);
    }
  };

  // --- INICIAR VENTA ---
  const iniciarVenta = async () => {
    try {
      setMensaje("");
      const idUsuario = 1; // temporal — luego vendrá del contexto/auth
      const idCliente = 1; // Consumidor Final por defecto
      const idTipoVenta = 1; // Efectivo por defecto

      const data = await iniciarVentaService(idUsuario, idCliente, idTipoVenta);
      console.log("✅ Venta iniciada:", data);

      setVentaActiva({
        id_venta: data.id_venta,
        fecha: data.fecha,
        cliente: data.cliente,
        doc_afip: data.doc_afip,
        domicilio: data.domicilio,
        localidad: data.localidad,
        forma_pago: data.forma_pago,
        iva: data.iva,
      });

      setClienteSeleccionado({
        id_cliente: idCliente,
        razon_social: data.cliente,
        iva: data.iva,
      });
      setFormaPago({
        id_formaDePago: idTipoVenta,
        nombre: data.forma_pago,
      });

      setEstadoVenta("activa");
      setDetalleVenta([]);
      setTotales({
        cantidad_productos: 0,
        total_neto: 0,
        iva_10_5: 0,
        iva_21: 0,
        total_final: 0,
      });
      setCodigoProducto("");
      setCantidadProducto(1);
    } catch (error) {
      console.error("❌ Error al iniciar venta:", error);
      setMensaje(error.message || "Error al iniciar venta");
      setTipoMensaje("error");
    }
  };

  // --- CAMBIAR CLIENTE ---
  const cambiarCliente = async (cliente) => {
    if (!ventaActiva) return;

    try {
      const data = await actualizarCabecera(ventaActiva.id_venta, {
        id_cliente: cliente.id_cliente,
      });

      // Actualizar cabecera con los nuevos datos
      setVentaActiva({
        ...ventaActiva,
        cliente: data.cliente,
        doc_afip: data.doc_afip,
        domicilio: data.domicilio,
        localidad: data.localidad,
        iva: data.iva,
      });

      setClienteSeleccionado({
        id_cliente: cliente.id_cliente,
        razon_social: data.cliente,
        iva: data.iva,
      });

      setOpenCliente(false);
      setBusquedaCliente("");
    } catch (error) {
      console.error("Error al cambiar cliente:", error);
      setMensaje(error.message || "Error al cambiar cliente");
      setTipoMensaje("error");
    }
  };

  // --- CAMBIAR FORMA DE PAGO ---
  const cambiarFormaPago = async (forma) => {
    if (!ventaActiva) return;

    try {
      const data = await actualizarCabecera(ventaActiva.id_venta, {
        id_tipo_venta: forma.id_formaDePago,
      });

      setVentaActiva({
        ...ventaActiva,
        forma_pago: data.forma_pago,
      });

      setFormaPago({
        id_formaDePago: forma.id_formaDePago,
        nombre: data.forma_pago,
      });

      setOpenPago(false);
      setBusquedaPago("");
    } catch (error) {
      console.error("Error al cambiar forma de pago:", error);
      setMensaje(error.message || "Error al cambiar forma de pago");
      setTipoMensaje("error");
    }
  };

  // --- AGREGAR PRODUCTO ---
  const agregarProductoDetalle = async (producto = null, cantidad = null) => {
    if (!ventaActiva) {
      setMensaje("Debe iniciar una venta primero");
      setTipoMensaje("error");
      return;
    }

    let prod = producto;
    let cant = cantidad || cantidadProducto;

    if (!prod) {
      // Validar que haya código
      if (!codigoProducto || codigoProducto.trim() === "") {
        setMensaje("Ingrese un código de producto");
        setTipoMensaje("error");
        return;
      }
      
      // Validar cantidad
      if (cant <= 0) {
        setMensaje("La cantidad debe ser mayor a 0");
        setTipoMensaje("error");
        return;
      }

      // Buscar producto por código
      prod = productos.find((p) => p.codigo === codigoProducto);
      if (!prod) {
        setMensaje(`Producto con código "${codigoProducto}" no encontrado`);
        setTipoMensaje("error");
        setCodigoProducto("");
        // Volver el focus al input de código
        setTimeout(() => codigoInputRef.current?.focus(), 100);
        return;
      }
    }

    try {
      // Enviar al backend
      await agregarProductoService(
        ventaActiva.id_venta,
        prod.codigo,
        cant
      );

      // Actualizar detalle y totales desde backend
      await actualizarDetalle(ventaActiva.id_venta);
      await actualizarTotales(ventaActiva.id_venta);

      // Limpiar campos
      setCodigoProducto("");
      setCantidadProducto(1);
      
      // Volver el focus al input de código para siguiente escaneo
      setTimeout(() => codigoInputRef.current?.focus(), 100);
    } catch (error) {
      console.error("Error al agregar producto:", error);
      setMensaje(error.message || "Error al agregar producto");
      setTipoMensaje("error");
    }
  };

  // --- ELIMINAR PRODUCTO ---
  const eliminarProducto = async (codigo) => {
    if (!ventaActiva) return;

    try {
      await eliminarProductoService(ventaActiva.id_venta, codigo);

      // Actualizar detalle y totales desde backend
      await actualizarDetalle(ventaActiva.id_venta);
      await actualizarTotales(ventaActiva.id_venta);
    } catch (error) {
      console.error("Error al eliminar producto:", error);
      setMensaje(error.message || "Error al eliminar producto");
      setTipoMensaje("error");
    }
  };

  // --- FINALIZAR VENTA ---
  const finalizarVenta = async () => {
    if (!ventaActiva || detalleVenta.length === 0) {
      setMensaje("No hay productos en la venta");
      setTipoMensaje("error");
      return;
    }

    try {
      await finalizarVentaService(ventaActiva.id_venta);

      setMensaje("¡Venta finalizada correctamente!");
      setTipoMensaje("success");
      setEstadoVenta("finalizada");

      // Resetear después de un breve delay
      setTimeout(() => {
        setVentaActiva(null);
        setEstadoVenta("inactiva");
        setDetalleVenta([]);
        setTotales({
          cantidad_productos: 0,
          total_neto: 0,
          iva_10_5: 0,
          iva_21: 0,
          total_final: 0,
        });
      }, 2000);
    } catch (error) {
      console.error("Error al finalizar venta:", error);
      setMensaje(error.message || "Error al finalizar venta");
      setTipoMensaje("error");
    }
  };

  // --- CERRAR/CANCELAR VENTA ---
  const cerrarVenta = async () => {
    if (!ventaActiva) return;

    if (
      !window.confirm(
        "¿Está seguro de cancelar la venta? Se perderán todos los datos."
      )
    ) {
      return;
    }

    try {
      await cancelarVentaService(ventaActiva.id_venta);

      setMensaje("Venta cancelada");
      setTipoMensaje("info");
      setVentaActiva(null);
      setEstadoVenta("inactiva");
      setDetalleVenta([]);
      setTotales({
        cantidad_productos: 0,
        total_neto: 0,
        iva_10_5: 0,
        iva_21: 0,
        total_final: 0,
      });
    } catch (error) {
      console.error("Error al cancelar venta:", error);
      setMensaje(error.message || "Error al cancelar venta");
      setTipoMensaje("error");
    }
  };

  const nuevaVenta = () => iniciarVenta();

  // --- RETURN ---
  return (
    <Box sx={{ p: 2, display: "flex", flexDirection: "column", gap: 3 }}>
      {/* Botón iniciar venta */}
      <Box sx={{ alignSelf: "flex-start" }}>
        <Button
          variant="contained"
          color="success"
          onClick={() => iniciarVenta()}
          disabled={estadoVenta === "activa"}
        >
          Iniciar Venta
        </Button>
      </Box>

      {/* Mensaje de alerta */}
      {mensaje && (
        <Alert severity={tipoMensaje} onClose={() => setMensaje("")}>
          {mensaje}
        </Alert>
      )}

      {/* Cabecera dinámica */}
      {ventaActiva && (
        <Paper sx={{ p: 1, py: 0.5}}>
          <Typography variant="subtitle2" sx={{ mb: 0.5, fontWeight: 600 }}>
            Cabecera de Venta
          </Typography>
          <Box sx={{ display: "flex", flexWrap: "wrap", gap: 0.8, alignItems: "flex-end", pb: 1.5 }}>
            <TextField
              label="Nro Venta"
              size="small"
              disabled
              value={ventaActiva.id_venta}
              sx={{
                width: 90,
                '& .MuiInputBase-input.Mui-disabled': {
                  WebkitTextFillColor: '#000',
                  color: '#000',
                  fontSize: '0.813rem',
                  padding: '6px 8px'
                },
                '& .MuiInputLabel-root': {
                  fontSize: '0.75rem'
                }
              }}
            />
            <TextField
              label="Fecha"
              size="small"
              disabled
              value={ventaActiva.fecha}
              sx={{
                width: 150,
                '& .MuiInputBase-input.Mui-disabled': {
                  WebkitTextFillColor: '#000',
                  color: '#000',
                  fontSize: '0.813rem',
                  padding: '6px 8px'
                },
                '& .MuiInputLabel-root': {
                  fontSize: '0.75rem'
                }
              }}
            />
            <TextField
              label="Doc AFIP"
              size="small"
              disabled
              value={ventaActiva.doc_afip}
              sx={{
                width: 110,
                '& .MuiInputBase-input.Mui-disabled': {
                  WebkitTextFillColor: '#000',
                  color: '#000',
                  fontSize: '0.813rem',
                  padding: '6px 8px'
                },
                '& .MuiInputLabel-root': {
                  fontSize: '0.75rem'
                }
              }}
            />
            <Tooltip title={ventaActiva.domicilio || ""} arrow>
              <TextField
                label="Domicilio"
                size="small"
                disabled
                value={ventaActiva.domicilio}
                sx={{
                  width: 120,
                  '& .MuiInputBase-input.Mui-disabled': {
                    WebkitTextFillColor: '#000',
                    color: '#000',
                    fontSize: '0.813rem',
                    padding: '6px 8px',
                    textOverflow: 'ellipsis',
                    overflow: 'hidden',
                    whiteSpace: 'nowrap'
                  },
                  '& .MuiInputLabel-root': {
                    fontSize: '0.75rem'
                  }
                }}
              />
            </Tooltip>
            <TextField
              label="Localidad / CP"
              size="small"
              disabled
              value={ventaActiva.localidad}
              sx={{
                width: 100,
                '& .MuiInputBase-input.Mui-disabled': {
                  WebkitTextFillColor: '#000',
                  color: '#000',
                  fontSize: '0.813rem',
                  padding: '6px 8px'
                },
                '& .MuiInputLabel-root': {
                  fontSize: '0.75rem'
                }
              }}
            />

            {/* Cliente */}
            <Box sx={{ display: "flex", flexDirection: "column", gap: 0.3 }}>
              <Button
                variant="outlined"
                size="small"
                sx={{ height: 24, fontSize: '0.75rem', padding: '2px 8px' }}
                onClick={() => setOpenCliente(true)}
              >
                Cambiar Cliente
              </Button>
              <Tooltip title={clienteSeleccionado?.razon_social || ""} arrow>
                <TextField
                  size="small"
                  disabled
                  value={clienteSeleccionado?.razon_social || ""}
                  sx={{
                    width: 160,
                    '& .MuiInputBase-input.Mui-disabled': {
                      WebkitTextFillColor: '#000',
                      color: '#000',
                      fontSize: '0.813rem',
                      padding: '6px 8px',
                      textOverflow: 'ellipsis',
                      overflow: 'hidden',
                      whiteSpace: 'nowrap'
                    }
                  }}
                />
              </Tooltip>
            </Box>

            {/* Forma de Pago */}
            <Box sx={{ display: "flex", flexDirection: "column", gap: 0.3 }}>
              <Button
                variant="outlined"
                size="small"
                sx={{ height: 24, fontSize: '0.75rem', padding: '2px 8px' }}
                onClick={() => setOpenPago(true)}
              >
                Cambiar Forma Pago
              </Button>
              <Tooltip title={formaPago?.nombre || ""} arrow>
                <TextField
                  size="small"
                  disabled
                  value={formaPago?.nombre || ""}
                  sx={{
                    width: 140,
                    '& .MuiInputBase-input.Mui-disabled': {
                      WebkitTextFillColor: '#000',
                      color: '#000',
                      fontSize: '0.813rem',
                      padding: '6px 8px',
                      textOverflow: 'ellipsis',
                      overflow: 'hidden',
                      whiteSpace: 'nowrap'
                    }
                  }}
                />
              </Tooltip>
            </Box>

            {/* IVA (solo lectura, se trae del cliente) */}
            <Tooltip title={ventaActiva.iva || ""} arrow>
              <TextField
                label="Condición IVA"
                size="small"
                disabled
                value={ventaActiva.iva || ""}
                sx={{
                  width: 140,
                  '& .MuiInputBase-input.Mui-disabled': {
                    WebkitTextFillColor: '#000',
                    color: '#000',
                    fontSize: '0.813rem',
                    padding: '6px 8px',
                    textOverflow: 'ellipsis',
                    overflow: 'hidden',
                    whiteSpace: 'nowrap'
                  },
                  '& .MuiInputLabel-root': {
                    fontSize: '0.75rem'
                  }
                }}
              />
            </Tooltip>
          </Box>
        </Paper>
      )}
      {/* Productos + Totales */}
      <Box sx={{ display: "flex", gap: 2, flexWrap: "wrap" }}>
        {/* Productos */}
        <Paper sx={{ p: 2, flex: 3, minWidth: 300 }}>
          <Typography variant="h6">Productos</Typography>
          <TableContainer sx={{ maxHeight: 300, overflowY: "auto" }}>
            <Table size="small" stickyHeader>
              <TableHead>
                <TableRow>
                  <TableCell>Cantidad</TableCell>
                  <TableCell>Detalle</TableCell>
                  <TableCell>Precio Unit.</TableCell>
                  <TableCell>Total</TableCell>
                  <TableCell>Acciones</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {detalleVenta.map((item, index) => (
                  <TableRow key={index}>
                    <TableCell>{parseFloat(item.cant).toFixed(2)}</TableCell>
                    <TableCell>{item.detalle}</TableCell>
                    <TableCell>
                      ${parseFloat(item.precio_venta || 0).toFixed(2)}
                    </TableCell>
                    <TableCell>
                      ${parseFloat(item.total || 0).toFixed(2)}
                    </TableCell>
                    <TableCell>
                      <Button
                        variant="outlined"
                        color="error"
                        size="small"
                        onClick={() => eliminarProducto(item.codigo)}
                      >
                        Eliminar
                      </Button>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>


          {/* Botones de atajos */}
          <Box sx={{ display: "flex", gap: 1, flexWrap: "wrap", mt: 2 }}>
            <Button variant="outlined" onClick={() => nuevaVenta()}>Nueva Venta</Button>
            <Button variant="outlined" color="error" onClick={() => cerrarVenta()}>Cerrar Venta</Button>
            <Button variant="outlined" onClick={() => setOpenBuscarProducto(true)}>Buscar Producto</Button>
            <Button variant="outlined" onClick={() => setOpenCalculadora(true)}>Calc</Button>
            <Button variant="outlined" onClick={() => setOpenCtaCte(true)}>Cta.Cte.</Button>
          </Box>

          {/* Inputs código/cantidad */}
          <Box sx={{ display: "flex", gap: 2, mt: 2 }}>
            <TextField
              label="Código"
              size="small"
              fullWidth
              value={codigoProducto}
              onChange={(e) => setCodigoProducto(e.target.value)}
              onKeyDown={(e) => {
                if (e.key === "Enter") {
                  e.preventDefault();
                  agregarProductoDetalle();
                }
              }}
              inputRef={codigoInputRef}
              autoFocus
              disabled={estadoVenta !== "activa"}
              placeholder="Escanee o ingrese código..."
            />
            <TextField
              label="Cantidad"
              size="small"
              fullWidth
              type="number"
              inputProps={{ min: 0.01, step: 0.01 }}
              value={cantidadProducto}
              onChange={(e) => setCantidadProducto(Number(e.target.value))}
              onKeyDown={(e) => {
                if (e.key === "Enter") {
                  e.preventDefault();
                  agregarProductoDetalle();
                }
              }}
              disabled={estadoVenta !== "activa"}
            />
          </Box>
        </Paper>

        {/* Totales */}
        <Paper sx={{ p: 2, flex: 1, minWidth: 200 }}>
          <Typography variant="h6">Totales</Typography>
          <Typography>
            Cantidad de productos: {Math.round(totales.cantidad_productos)}
          </Typography>
          <Typography>
            Precio Neto: ${totales.total_neto.toFixed(2)}
          </Typography>
          <Typography>
            IVA 10.5%: ${totales.iva_10_5.toFixed(2)}
          </Typography>
          <Typography>IVA 21%: ${totales.iva_21.toFixed(2)}</Typography>
          <Typography variant="h6" mt={1}>
            TOTAL: ${totales.total_final.toFixed(2)}
          </Typography>

          <Typography variant="subtitle2" mt={2}>
            Estado: {estadoVenta}
          </Typography>

          <Button
            variant="contained"
            color="primary"
            fullWidth
            sx={{ mt: 2 }}
            onClick={finalizarVenta}
            disabled={estadoVenta !== "activa" || detalleVenta.length === 0}
          >
            Facturar
          </Button>
        </Paper>
      </Box>

      {/* --- DIALOG: CLIENTES --- */}
      <Dialog
        open={openCliente}
        onClose={() => setOpenCliente(false)}
        fullWidth
        maxWidth="sm"
      >
        <DialogTitle>Seleccionar Cliente</DialogTitle>
        <DialogContent>
          <TextField
            label="Buscar cliente..."
            fullWidth
            value={busquedaCliente}
            onChange={(e) => setBusquedaCliente(e.target.value)}
            sx={{ mb: 2, mt: 1 }}
          />
          {clientesFiltrados.map((c) => (
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
              onClick={() => cambiarCliente(c)}
            >
              <Typography variant="body1">{c.razon_social}</Typography>
              <Typography variant="caption" color="textSecondary">
                Doc: {c.nro_doc} | IVA: {c.iva}
              </Typography>
            </Box>
          ))}
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpenCliente(false)}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      {/* --- DIALOG: FORMAS DE PAGO --- */}
      <Dialog
        open={openPago}
        onClose={() => setOpenPago(false)}
        fullWidth
        maxWidth="sm"
      >
        <DialogTitle>Seleccionar Forma de Pago</DialogTitle>
        <DialogContent>
          <TextField
            label="Buscar forma de pago..."
            fullWidth
            value={busquedaPago}
            onChange={(e) => setBusquedaPago(e.target.value)}
            sx={{ mb: 2, mt: 1 }}
          />
          {formasPagoFiltradas.map((f) => (
            <Box
              key={f.id_formaDePago}
              sx={{
                p: 1,
                border: "1px solid #ccc",
                borderRadius: 1,
                mb: 1,
                cursor: "pointer",
                "&:hover": { backgroundColor: "#f5f5f5" },
              }}
              onClick={() => cambiarFormaPago(f)}
            >
              <Typography>{f.nombre}</Typography>
            </Box>
          ))}
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpenPago(false)}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      {/* Buscar Producto */}
      <Dialog open={openBuscarProducto} onClose={() => setOpenBuscarProducto(false)} fullWidth>
        <DialogTitle>Buscar Producto</DialogTitle>
        <DialogContent>
          <TextField
            label="Buscar..."
            fullWidth
            value={busquedaProductoDialog}
            onChange={(e) => setBusquedaProductoDialog(e.target.value)}
            sx={{ mb: 2 }}
          />
          {productosFiltradosDialog.map((p) => (
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
                agregarProductoDetalle(p, 1);
                setOpenBuscarProducto(false);
                setBusquedaProductoDialog("");
              }}
            >
              <Typography>{p.detalle}</Typography>
            </Box>
          ))}
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpenBuscarProducto(false)}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      {/* Calculadora */}
      <Dialog open={openCalculadora} onClose={() => setOpenCalculadora(false)}>
        <DialogTitle>Calculadora</DialogTitle>
        <DialogContent>
          <Typography>Acá iría la calculadora.</Typography>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpenCalculadora(false)}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      {/* Cuenta Corriente */}
      <Dialog open={openCtaCte} onClose={() => setOpenCtaCte(false)}>
        <DialogTitle>Cuenta Corriente</DialogTitle>
        <DialogContent>
          <Typography>Acá se manejaría la cuenta corriente.</Typography>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setOpenCtaCte(false)}>Cerrar</Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}

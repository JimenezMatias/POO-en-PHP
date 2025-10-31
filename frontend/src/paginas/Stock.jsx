import { useState, useRef, useEffect } from "react";
import {
  Box,
  Paper,
  Typography,
  TextField,
  Button,
  Alert,
  Chip,
} from "@mui/material";
import { buscarArticuloPorCodigo, sumarStock, actualizarPrecio } from "../servicios/stockService";

const Stock = () => {
  // Estados
  const [codigo, setCodigo] = useState("");
  const [disponible, setDisponible] = useState("##");
  const [precioVta, setPrecioVta] = useState("##");
  const [detalle, setDetalle] = useState("--");
  const [sumarCantidad, setSumarCantidad] = useState(0);
  const [actualizarPrecioValor, setActualizarPrecioValor] = useState("");
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  const [productoActual, setProductoActual] = useState(null);

  // Referencias para auto-focus
  const codigoInputRef = useRef(null);
  const sumarInputRef = useRef(null);
  const actualizarInputRef = useRef(null);

  useEffect(() => {
    // Focus inicial en código
    codigoInputRef.current?.focus();
  }, []);

  // Buscar artículo al presionar Enter o perder foco
  const handleBuscarArticulo = async () => {
    if (!codigo || codigo.trim() === "") return;

    try {
      setError(null);
      const producto = await buscarArticuloPorCodigo(codigo);
      
      setProductoActual(producto);
      setDisponible(parseFloat(producto.stock).toFixed(2));
      setPrecioVta(parseFloat(producto.precio_venta).toFixed(2));
      setDetalle(producto.detalle);
      
      // Focus en SUMAR después de buscar
      sumarInputRef.current?.focus();
    } catch (err) {
      setError(err.error || "Producto no encontrado");
      limpiarCampos();
    }
  };

  // Sumar stock al presionar Enter
  const handleSumarStock = async () => {
    if (!productoActual) {
      setError("Primero debes buscar un artículo");
      return;
    }

    if (sumarCantidad === 0 || sumarCantidad === "") {
      setError("La cantidad no puede ser 0");
      return;
    }

    try {
      setError(null);
      const response = await sumarStock(codigo, parseFloat(sumarCantidad));
      
      setSuccess(response.mensaje);
      setDisponible(parseFloat(response.producto.stock).toFixed(2));
      setSumarCantidad(0);
      
      // Limpiar mensaje después de 3 segundos
      setTimeout(() => setSuccess(null), 3000);
      
      // Focus de vuelta en SUMAR
      sumarInputRef.current?.focus();
    } catch (err) {
      setError(err.error || "Error al actualizar el stock");
    }
  };

  // Actualizar precio al presionar Enter
  const handleActualizarPrecio = async () => {
    if (!productoActual) {
      setError("Primero debes buscar un artículo");
      return;
    }

    if (!actualizarPrecioValor || parseFloat(actualizarPrecioValor) <= 0) {
      setError("El precio debe ser mayor a 0");
      return;
    }

    try {
      setError(null);
      const response = await actualizarPrecio(codigo, parseFloat(actualizarPrecioValor));
      
      setSuccess(response.mensaje);
      setPrecioVta(parseFloat(response.producto.precio_venta).toFixed(2));
      setActualizarPrecioValor("");
      
      // Limpiar mensaje después de 3 segundos
      setTimeout(() => setSuccess(null), 3000);
      
      // Focus de vuelta en ACTUALIZAR
      actualizarInputRef.current?.focus();
    } catch (err) {
      setError(err.error || "Error al actualizar el precio");
    }
  };

  // Limpiar todos los campos
  const limpiarCampos = () => {
    setCodigo("");
    setDisponible("##");
    setPrecioVta("##");
    setDetalle("--");
    setSumarCantidad(0);
    setActualizarPrecioValor("");
    setProductoActual(null);
    setError(null);
    setSuccess(null);
    codigoInputRef.current?.focus();
  };

  // Handlers de teclado
  const handleCodigoKeyPress = (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      handleBuscarArticulo();
    }
  };

  const handleSumarKeyPress = (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      handleSumarStock();
    }
  };

  const handleActualizarKeyPress = (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      handleActualizarPrecio();
    }
  };

  return (
    <Box sx={{ p: 3 }}>
      {/* Título */}
      <Paper sx={{ p: 2, mb: 2, bgcolor: "#555" }}>
        <Typography
          variant="h5"
          sx={{ color: "#fff", fontWeight: 600, textAlign: "center" }}
        >
          INGRESOS DE MERCADERÍA
        </Typography>
      </Paper>

      {/* Mensajes */}
      {error && (
        <Alert severity="error" sx={{ mb: 2 }} onClose={() => setError(null)}>
          {error}
        </Alert>
      )}
      {success && (
        <Alert severity="success" sx={{ mb: 2 }} onClose={() => setSuccess(null)}>
          {success}
        </Alert>
      )}

      {/* Formulario principal */}
      <Paper sx={{ p: 3 }}>
        {/* Buscar artículo */}
        <Box sx={{ mb: 3 }}>
          <Typography variant="subtitle2" sx={{ mb: 1, fontWeight: 600 }}>
            Buscar artículo x CODIGO
          </Typography>
          <TextField
            fullWidth
            value={codigo}
            onChange={(e) => setCodigo(e.target.value)}
            onKeyPress={handleCodigoKeyPress}
            onBlur={handleBuscarArticulo}
            inputRef={codigoInputRef}
            placeholder="Ingrese o escanee el código del producto"
            sx={{ bgcolor: "#fff" }}
          />
        </Box>

        {/* DISPONIBLE, SUMAR, PRECIO VTA */}
        <Box
          sx={{
            display: "flex",
            gap: 2,
            mb: 3,
            flexWrap: "wrap",
            alignItems: "flex-start",
          }}
        >
          {/* DISPONIBLE */}
          <Box sx={{ flex: "1 1 200px" }}>
            <Typography variant="subtitle2" sx={{ mb: 1, fontWeight: 600 }}>
              DISPONIBLE
            </Typography>
            <Box
              sx={{
                p: 2,
                bgcolor: "#FF8C00",
                color: "#fff",
                fontWeight: 700,
                fontSize: "1.5rem",
                textAlign: "center",
                borderRadius: 1,
                minHeight: "56px",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
              }}
            >
              {disponible}
              {productoActual && parseFloat(disponible) < 0 && (
                <Chip
                  label="NEGATIVO"
                  color="error"
                  size="small"
                  sx={{ ml: 1 }}
                />
              )}
            </Box>
          </Box>

          {/* SUMAR */}
          <Box sx={{ flex: "1 1 200px" }}>
            <Typography variant="subtitle2" sx={{ mb: 1, fontWeight: 600 }}>
              SUMAR
            </Typography>
            <TextField
              fullWidth
              type="number"
              value={sumarCantidad}
              onChange={(e) => setSumarCantidad(e.target.value)}
              onKeyPress={handleSumarKeyPress}
              inputRef={sumarInputRef}
              placeholder="Positivo o negativo"
              sx={{ bgcolor: "#fff" }}
              InputProps={{
                inputProps: {
                  step: "0.01",
                },
              }}
            />
          </Box>

          {/* PRECIO VTA */}
          <Box sx={{ flex: "1 1 200px" }}>
            <Typography variant="subtitle2" sx={{ mb: 1, fontWeight: 600 }}>
              PRECIO VTA ($)
            </Typography>
            <Box
              sx={{
                p: 2,
                bgcolor: "#FF8C00",
                color: "#fff",
                fontWeight: 700,
                fontSize: "1.5rem",
                textAlign: "center",
                borderRadius: 1,
                minHeight: "56px",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
              }}
            >
              {precioVta}
            </Box>
          </Box>
        </Box>

        {/* ACTUALIZAR ($) */}
        <Box sx={{ mb: 3 }}>
          <Typography variant="subtitle2" sx={{ mb: 1, fontWeight: 600 }}>
            ACTUALIZAR ($)
          </Typography>
          <TextField
            fullWidth
            type="number"
            value={actualizarPrecioValor}
            onChange={(e) => setActualizarPrecioValor(e.target.value)}
            onKeyPress={handleActualizarKeyPress}
            inputRef={actualizarInputRef}
            placeholder="Nuevo precio de venta"
            sx={{ bgcolor: "#fff" }}
            InputProps={{
              inputProps: {
                step: "0.01",
                min: "0",
              },
            }}
          />
        </Box>

        {/* Artículo */}
        <Box sx={{ mb: 2 }}>
          <Typography variant="subtitle2" sx={{ mb: 1, fontWeight: 600 }}>
            Artículo:
          </Typography>
          <Typography
            variant="body1"
            sx={{
              color: detalle === "--" ? "#FF8C00" : "#000",
              fontWeight: detalle === "--" ? 700 : 400,
              fontSize: "1.1rem",
            }}
          >
            {detalle}
          </Typography>
        </Box>

        {/* Botón Limpiar */}
        <Box sx={{ display: "flex", justifyContent: "flex-end" }}>
          <Button variant="outlined" onClick={limpiarCampos} color="secondary">
            Limpiar
          </Button>
        </Box>
      </Paper>

      {/* Instrucciones */}
      <Paper sx={{ p: 2, mt: 2, bgcolor: "#f5f5f5" }}>
        <Typography variant="body2" sx={{ fontWeight: 600, mb: 1 }}>
          📌 Instrucciones:
        </Typography>
        <Typography variant="body2">
          1️⃣ <strong>Buscar producto:</strong> Ingrese el código y presione Enter o haga clic fuera del campo
        </Typography>
        <Typography variant="body2">
          2️⃣ <strong>Sumar stock:</strong> Ingrese cantidad (positiva o negativa) y presione Enter
        </Typography>
        <Typography variant="body2">
          3️⃣ <strong>Actualizar precio:</strong> Ingrese nuevo precio y presione Enter
        </Typography>
        <Typography variant="body2" sx={{ mt: 1, color: "#d32f2f" }}>
          ⚠️ <strong>Stock negativo permitido:</strong> Indica que debe reponer mercadería
        </Typography>
      </Paper>
    </Box>
  );
};

export default Stock;


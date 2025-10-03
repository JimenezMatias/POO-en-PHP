import React, { useState } from "react";
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
} from "@mui/material";

export default function Ventas() {
  const [ventaIniciada, setVentaIniciada] = useState(false);
  const [dialogOpen, setDialogOpen] = useState(null);

  const handleIniciarVenta = () => {
    setVentaIniciada(true);
    console.log("Se inicia venta → llamar procedure backend");
  };

  const handleOpenDialog = (tipo) => setDialogOpen(tipo);
  const handleCloseDialog = () => setDialogOpen(null);

  return (
    <Box sx={{ p: 2, display: "flex", flexDirection: "column", gap: 3 }}>
      
      {/* Botón iniciar venta */}
      <Box sx={{ alignSelf: "flex-start" }}>
        <Button
          variant="contained"
          color="success"
          onClick={handleIniciarVenta}
          disabled={ventaIniciada}
        >
          Iniciar Venta
        </Button>
      </Box>

      {/* Cabecera */}
      <Paper sx={{ p: 2 }}>
        <Typography variant="h6" gutterBottom>Cabecera de Venta</Typography>
        <Box sx={{ display: "flex", flexWrap: "wrap", gap: 2 }}>
          <TextField
            label="Nro Venta"
            size="small"
            disabled
            value={ventaIniciada ? "0001" : ""}
          />
          <TextField
            label="Fecha"
            size="small"
            disabled
            value={ventaIniciada ? new Date().toLocaleString() : ""}
          />
          <Button
            variant="outlined"
            sx={{ height: 40 }}
            onClick={() => handleOpenDialog("cliente")}
          >
            Seleccionar Cliente
          </Button>
          <Button
            variant="outlined"
            sx={{ height: 40 }}
            onClick={() => handleOpenDialog("formaPago")}
          >
            Forma de Pago
          </Button>
          <Button
            variant="outlined"
            sx={{ height: 40 }}
            onClick={() => handleOpenDialog("iva")}
          >
            Seleccionar IVA
          </Button>
        </Box>
      </Paper>

      {/* Productos + Totales */}
      <Box sx={{ display: "flex", gap: 2, flexWrap: "wrap" }}>
        {/* Productos */}
        <Paper sx={{ p: 2, flex: 3, minWidth: 300 }}>
          <Typography variant="h6">Productos</Typography>
          <TableContainer>
            <Table size="small">
              <TableHead>
                <TableRow>
                  <TableCell>Cant</TableCell>
                  <TableCell>Detalle</TableCell>
                  <TableCell>Precio Unit.</TableCell>
                  <TableCell>Total</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>{/* filas dinámicas */}</TableBody>
            </Table>
          </TableContainer>

          {/* Botones de atajos */}
          <Box sx={{ display: "flex", gap: 1, flexWrap: "wrap", mt: 2 }}>
            <Button variant="outlined" onClick={handleIniciarVenta}>
              F5 - Nueva Venta
            </Button>
            <Button variant="outlined" color="error">F2 - Cerrar Venta</Button>
            <Button variant="outlined" onClick={() => handleOpenDialog("buscarProducto")}>
              F8 - Buscar Producto
            </Button>
            <Button variant="outlined" onClick={() => handleOpenDialog("calc")}>
              F9 - Calc
            </Button>
            <Button variant="outlined" onClick={() => handleOpenDialog("ctacte")}>
              F10 - Cta.Cte.
            </Button>
          </Box>

          {/* Inputs código/cantidad */}
          <Box sx={{ display: "flex", gap: 2, mt: 2 }}>
            <TextField label="Código" size="small" fullWidth />
            <TextField label="Cantidad" size="small" fullWidth />
          </Box>
        </Paper>

        {/* Totales */}
        <Paper sx={{ p: 2, flex: 1, minWidth: 200 }}>
          <Typography variant="h6">Totales</Typography>
          <Typography>Precio Neto: $0.00</Typography>
          <Typography>IVA 10.5%: $0.00</Typography>
          <Typography>IVA 21%: $0.00</Typography>
          <Typography variant="h6" mt={1}>TOTAL: $0.00</Typography>
          <Typography variant="subtitle2" mt={2}>
            Estado: {ventaIniciada ? "Abierta" : "Sin iniciar"}
          </Typography>
          <Button variant="contained" color="primary" fullWidth sx={{ mt: 2 }}>
            Facturar
          </Button>
        </Paper>
      </Box>

      {/* --- Dialogs --- */}
      <Dialog open={dialogOpen === "cliente"} onClose={handleCloseDialog} fullWidth>
        <DialogTitle>Seleccionar Cliente</DialogTitle>
        <DialogContent>
          <TextField label="Buscar cliente..." fullWidth />
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDialog}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      <Dialog open={dialogOpen === "formaPago"} onClose={handleCloseDialog} fullWidth>
        <DialogTitle>Seleccionar Forma de Pago</DialogTitle>
        <DialogContent>
          <TextField label="Buscar forma de pago..." fullWidth />
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDialog}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      <Dialog open={dialogOpen === "iva"} onClose={handleCloseDialog} fullWidth>
        <DialogTitle>Seleccionar IVA</DialogTitle>
        <DialogContent>
          <Typography>IVA 10.5% / IVA 21%</Typography>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDialog}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      <Dialog open={dialogOpen === "buscarProducto"} onClose={handleCloseDialog} fullWidth>
        <DialogTitle>Buscar Producto</DialogTitle>
        <DialogContent>
          <TextField label="Buscar..." fullWidth />
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDialog}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      <Dialog open={dialogOpen === "calc"} onClose={handleCloseDialog}>
        <DialogTitle>Calculadora</DialogTitle>
        <DialogContent>
          <Typography>Acá iría la calculadora.</Typography>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDialog}>Cerrar</Button>
        </DialogActions>
      </Dialog>

      <Dialog open={dialogOpen === "ctacte"} onClose={handleCloseDialog}>
        <DialogTitle>Cuenta Corriente</DialogTitle>
        <DialogContent>
          <Typography>Acá se manejaría la cuenta corriente.</Typography>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseDialog}>Cerrar</Button>
        </DialogActions>
      </Dialog>

    </Box>
  );
}

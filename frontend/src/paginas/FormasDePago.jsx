import { useState, useEffect } from "react";
import {
  Box,
  Typography,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Button,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TextField,
} from "@mui/material";
import { listarFormasDePago, crearFormaDePago, editarFormaDePago, eliminarFormaDePago } from "../servicios/formaDePagoService";

export default function FormasDePago() {
  // Estado de la tabla
  const [formasDePago, setFormasDePago] = useState([]);

  // Estado para el diálogo de Alta/Edición
  const [dialogoAbierto, setDialogoAbierto] = useState(false);
  const [nombre, setNombre] = useState("");
  const [idEditar, setIdEditar] = useState(null);

  // Cargar formas de pago desde backend
  const cargarFormasDePago = async () => {
    try {
      const datos = await listarFormasDePago();
      setFormasDePago(datos);
    } catch (error) {
      console.error("Error al cargar formas de pago:", error);
    }
  };

  useEffect(() => {
    cargarFormasDePago();
  }, []);

  // Abrir diálogo para crear o editar
  const abrirDialogo = (forma = null) => {
    if (forma) {
      setIdEditar(forma.id_formaDePago);
      setNombre(forma.nombre);
    } else {
      setIdEditar(null);
      setNombre("");
    }
    setDialogoAbierto(true);
  };

  // Cerrar diálogo
  const cerrarDialogo = () => {
    setDialogoAbierto(false);
    setNombre("");
    setIdEditar(null);
  };

  // Guardar forma de pago (crear o editar)
  const guardarForma = async () => {
    try {
      if (idEditar) {
        await editarFormaDePago(idEditar, nombre);
      } else {
        await crearFormaDePago(nombre);
      }
      cargarFormasDePago();
      cerrarDialogo();
    } catch (error) {
      console.error("Error al guardar forma de pago:", error);
    }
  };

  // Eliminar forma de pago
  const eliminarForma = async (id) => {
    try {
      await eliminarFormaDePago(id);
      cargarFormasDePago();
    } catch (error) {
      console.error("Error al eliminar forma de pago:", error);
    }
  };

  return (
    <Box>
      <Typography variant="h5" mb={2}>
        Formas de Pago
      </Typography>
      <Button variant="contained" color="primary" onClick={() => abrirDialogo()}>
        Nueva Forma de Pago
      </Button>

      <TableContainer component={Paper} sx={{ mt: 2 }}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>ID</TableCell>
              <TableCell>Nombre</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {formasDePago.map((forma) => (
              <TableRow key={forma.id_formaDePago}>
                <TableCell>{forma.id_formaDePago}</TableCell>
                <TableCell>{forma.nombre}</TableCell>
                <TableCell>
                  <Button
                    variant="outlined"
                    color="secondary"
                    onClick={() => abrirDialogo(forma)}
                    sx={{ mr: 1 }}
                  >
                    Editar
                  </Button>
                  <Button
                    variant="outlined"
                    color="error"
                    onClick={() => eliminarForma(forma.id_formaDePago)}
                  >
                    Eliminar
                  </Button>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>

      {/* Diálogo de Alta/Edición */}
      <Dialog open={dialogoAbierto} onClose={cerrarDialogo}>
        <DialogTitle>
          {idEditar ? "Editar Forma de Pago" : "Nueva Forma de Pago"}
        </DialogTitle>
        <DialogContent>
          <TextField
            label="Nombre"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
            fullWidth
            sx={{ mt: 1 }}
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={cerrarDialogo}>Cancelar</Button>
          <Button onClick={guardarForma} variant="contained" color="primary">
            Guardar
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}

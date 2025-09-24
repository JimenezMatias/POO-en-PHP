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
import { listarUbicaciones, crearUbicacion, editarUbicacion, eliminarUbicacion } from "../servicios/ubicacionesService";

export default function Ubicaciones() {
  // Estado de la tabla
  const [ubicaciones, setUbicaciones] = useState([]);

  // Estado para el diálogo de Alta/Edición
  const [dialogoAbierto, setDialogoAbierto] = useState(false);
  const [descripcion, setDescripcion] = useState("");
  const [idEditar, setIdEditar] = useState(null);

  // Cargar ubicaciones desde backend
  const cargarUbicaciones = async () => {
    try {
      const datos = await listarUbicaciones();
      setUbicaciones(datos);
    } catch (error) {
      console.error("Error al cargar Ubicaciones:", error);
    }
  };

  useEffect(() => {
    cargarUbicaciones();
  }, []);

  // Abrir diálogo para crear o editar
  const abrirDialogo = (ubicacion = null) => {
    if (ubicacion) {
      setIdEditar(ubicacion.id_ubicacion);
      setDescripcion(ubicacion.desc_ubicacion);
    } else {
      setIdEditar(null);
      setDescripcion("");
    }
    setDialogoAbierto(true);
  };

  // Cerrar diálogo
  const cerrarDialogo = () => {
    setDialogoAbierto(false);
    setDescripcion("");
    setIdEditar(null);
  };

  // Guardar ubicación (crear o editar)
  const guardarUbicacion = async () => {
    try {
      if (idEditar) {
        await editarUbicacion(idEditar, descripcion);
      } else {
        await crearUbicacion(descripcion);
      }
      cargarUbicaciones();
      cerrarDialogo();
    } catch (error) {
      console.error("Error al guardar ubicación:", error);
    }
  };

  // Eliminar ubicación
  const eliminarUbicacionReact = async (id) => {
    try {
      await eliminarUbicacion(id);
      cargarUbicaciones();
    } catch (error) {
      console.error("Error al eliminar ubicación:", error);
    }
  };

  return (
    <Box>
      <Typography variant="h5" mb={2}>
        Ubicaciones
      </Typography>
      <Button variant="contained" color="primary" onClick={() => abrirDialogo()}>
        Nueva Ubicación
      </Button>

      <TableContainer component={Paper} sx={{ mt: 2 }}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>ID</TableCell>
              <TableCell>Descripción</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {ubicaciones.map((ubicacion) => (
              <TableRow key={ubicacion.id_ubicacion}>
                <TableCell>{ubicacion.id_ubicacion}</TableCell>
                <TableCell>{ubicacion.desc_ubicacion}</TableCell>
                <TableCell>
                  <Button
                    variant="outlined"
                    color="secondary"
                    onClick={() => abrirDialogo(ubicacion)}
                    sx={{ mr: 1 }}
                  >
                    Editar
                  </Button>
                  <Button
                    variant="outlined"
                    color="error"
                    onClick={() => eliminarUbicacionReact(ubicacion.id_ubicacion)}
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
          {idEditar ? "Editar Ubicación" : "Nueva Ubicación"}
        </DialogTitle>
        <DialogContent>
          <TextField
            label="Descripción"
            value={descripcion}
            onChange={(e) => setDescripcion(e.target.value)}
            fullWidth
            sx={{ mt: 1 }}
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={cerrarDialogo}>Cancelar</Button>
          <Button onClick={guardarUbicacion} variant="contained" color="primary">
            Guardar
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}


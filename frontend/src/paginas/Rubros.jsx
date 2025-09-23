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
import { listarRubros, crearRubro, editarRubro, eliminarRubro } from "../servicios/rubrosService";

export default function Rubros() {
  // Estado de la tabla
  const [rubros, setRubros] = useState([]);

  // Estado para el diálogo de Alta/Edición
  const [dialogoAbierto, setDialogoAbierto] = useState(false);
  const [nombre, setNombre] = useState("");
  const [idEditar, setIdEditar] = useState(null);

  // Cargar rubros desde backend
  const cargarRubro = async () => {
    try {
      const datos = await listarRubros();
      setRubros(datos);
    } catch (error) {
      console.error("Error al cargar Rubros:", error);
    }
  };

  useEffect(() => {
    cargarRubro();
  }, []);

  // Abrir diálogo para crear o editar
  const abrirDialogo = (forma = null) => {
    if (forma) {
      setIdEditar(forma.id_rubro);
      setNombre(forma.desc_rubro);
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

  // Guardar rubro (crear o editar)
  const guardarRubro = async () => {
    try {
      if (idEditar) {
        await editarRubro(idEditar, nombre);
      } else {
        await crearRubro(nombre);
      }
      cargarRubro();
      cerrarDialogo();
    } catch (error) {
      console.error("Error al guardar rubro:", error);
    }
  };

  // Eliminar forma de pago
  const eliminarRubroReact = async (id) => {
    try {
      await eliminarRubro(id);
      cargarRubro();
    } catch (error) {
      console.error("Error al eliminar rubro:", error);
    }
  };

  return (
    <Box>
      <Typography variant="h5" mb={2}>
        Rubros
      </Typography>
      <Button variant="contained" color="primary" onClick={() => abrirDialogo()}>
        Nuevo Rubro
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
            {rubros.map((forma) => (
              <TableRow key={forma.id_rubro}>
                <TableCell>{forma.id_rubro}</TableCell>
                <TableCell>{forma.desc_rubro}</TableCell>
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
                    onClick={() => eliminarRubroReact(forma.id_rubro)}
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
          {idEditar ? "Editar Rubro" : "Nuevo Rubro"}
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
          <Button onClick={guardarRubro} variant="contained" color="primary">
            Guardar
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}

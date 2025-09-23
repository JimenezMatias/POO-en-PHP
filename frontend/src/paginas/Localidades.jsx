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
  FormControl,
  InputLabel,
  Select,
  MenuItem,
} from "@mui/material";
import {
  listarLocalidades,
  crearLocalidad,
  editarLocalidad,
  eliminarLocalidad,
} from "../servicios/localidadesService";
import { listarProvincias } from "../servicios/provinciasService";

export default function Localidades() {
  // Estado de la tabla
  const [localidades, setLocalidades] = useState([]);

  // Provincias para el select
  const [provincias, setProvincias] = useState([]);

  // Estado del diálogo
  const [dialogoAbierto, setDialogoAbierto] = useState(false);
  const [cp, setCp] = useState("");
  const [localidad, setLocalidad] = useState("");
  const [idProvincia, setIdProvincia] = useState("");
  const [idEditar, setIdEditar] = useState(null);

  // Cargar localidades
  const cargarLocalidades = async () => {
    try {
      const datos = await listarLocalidades();
      setLocalidades(datos);
    } catch (error) {
      console.error("Error al cargar localidades:", error);
    }
  };

  // Cargar provincias
  const cargarProvincias = async () => {
    try {
      const datos = await listarProvincias();
      setProvincias(datos);
    } catch (error) {
      console.error("Error al cargar provincias:", error);
    }
  };

  useEffect(() => {
    cargarLocalidades();
    cargarProvincias();
  }, []);

  // Abrir diálogo
  const abrirDialogo = (loc = null) => {
    if (loc) {
      setIdEditar(loc.cp);
      setCp(loc.cp);
      setLocalidad(loc.localidad);
      setIdProvincia(loc.id_provincia);
    } else {
      setIdEditar(null);
      setCp("");
      setLocalidad("");
      setIdProvincia("");
    }
    setDialogoAbierto(true);
  };

  // Cerrar diálogo
  const cerrarDialogo = () => {
    setDialogoAbierto(false);
    setCp("");
    setLocalidad("");
    setIdProvincia("");
    setIdEditar(null);
  };

  // Guardar localidad
  const guardarLocalidad = async () => {
    try {
      if (idEditar) {
        await editarLocalidad(idEditar, { cp, localidad, id_provincia: idProvincia });
      } else {
        await crearLocalidad({ cp, localidad, id_provincia: idProvincia });
      }
      cargarLocalidades();
      cerrarDialogo();
    } catch (error) {
      console.error("Error al guardar localidad:", error);
    }
  };

  // Eliminar localidad
  const eliminarLoc = async (cp) => {
    try {
      await eliminarLocalidad(cp);
      cargarLocalidades();
    } catch (error) {
      console.error("Error al eliminar localidad:", error);
    }
  };

  return (
    <Box>
      <Typography variant="h5" mb={2}>
        Localidades
      </Typography>
      <Button variant="contained" color="primary" onClick={() => abrirDialogo()}>
        Nueva Localidad
      </Button>

      <TableContainer component={Paper} sx={{ mt: 2 }}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>CP</TableCell>
              <TableCell>Localidad</TableCell>
              <TableCell>Provincia</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {localidades.map((loc) => (
              <TableRow key={loc.cp}>
                <TableCell>{loc.cp}</TableCell>
                <TableCell>{loc.localidad}</TableCell>
                <TableCell>{loc.provincia}</TableCell>
                <TableCell>
                  <Button
                    variant="outlined"
                    color="secondary"
                    onClick={() => abrirDialogo(loc)}
                    sx={{ mr: 1 }}
                  >
                    Editar
                  </Button>
                  <Button
                    variant="outlined"
                    color="error"
                    onClick={() => eliminarLoc(loc.cp)}
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
        <DialogTitle>{idEditar ? "Editar Localidad" : "Nueva Localidad"}</DialogTitle>
        <DialogContent>
          <TextField
            label="CP"
            value={cp}
            onChange={(e) => setCp(e.target.value)}
            fullWidth
            sx={{ mt: 1 }}
            disabled={!!idEditar} // no permitir cambiar el cp en edición
          />
          <TextField
            label="Localidad"
            value={localidad}
            onChange={(e) => setLocalidad(e.target.value)}
            fullWidth
            sx={{ mt: 2 }}
          />
          <FormControl fullWidth sx={{ mt: 2 }}>
            <Select
              labelId="provincia-label"
              value={idProvincia}
              onChange={(e) => setIdProvincia(e.target.value)}
              displayEmpty
              renderValue={(selected) => {
                if (!selected) {
                  return <span style={{ color: "#aaa" }}>Provincia</span>;
                }
                const prov = provincias.find((p) => p.id_provincia === selected);
                return prov ? prov.provincia : "";
              }}
            >
              
              {provincias.map((prov) => (
                <MenuItem key={prov.id_provincia} value={prov.id_provincia}>
                  {prov.provincia}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </DialogContent>
        <DialogActions>
          <Button onClick={cerrarDialogo}>Cancelar</Button>
          <Button onClick={guardarLocalidad} variant="contained" color="primary">
            Guardar
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}

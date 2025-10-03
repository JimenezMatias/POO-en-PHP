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
  Select,
  MenuItem,
  FormControl,
  InputLabel,
} from "@mui/material";
import {
  listarUsuarios,
  crearUsuario,
  editarUsuario,
  eliminarUsuario,
} from "../servicios/usuarioService";
import { listarRoles } from "../servicios/rolesService"; // nuevo servicio para roles

export default function Usuarios() {
  // Estado de la tabla
  const [usuarios, setUsuarios] = useState([]);

  // Estado para roles
  const [roles, setRoles] = useState([]);

  // Estado para el diálogo de Alta/Edición
  const [dialogoAbierto, setDialogoAbierto] = useState(false);
  const [nombre, setNombre] = useState("");
  const [rol, setRol] = useState("");
  const [idEditar, setIdEditar] = useState(null);

  // Cargar Usuarios desde backend
  const cargarUsuarios = async () => {
    try {
      const datos = await listarUsuarios();
      setUsuarios(datos);
    } catch (error) {
      console.error("Error al cargar Usuarios", error);
    }
  };

  // Cargar Roles desde backend
  const cargarRoles = async () => {
    try {
      const datos = await listarRoles();
      setRoles(datos);
    } catch (error) {
      console.error("Error al cargar Roles", error);
    }
  };

  useEffect(() => {
    cargarUsuarios();
    cargarRoles();
  }, []);

  // Abrir diálogo para crear o editar
  const abrirDialogo = (forma = null) => {
    if (forma) {
      setIdEditar(forma.id_usuario);
      setNombre(forma.nombre);
      setRol(forma.id_rol); // viene de la BD
    } else {
      setIdEditar(null);
      setNombre("");
      setRol("");
    }
    setDialogoAbierto(true);
  };

  // Cerrar diálogo
  const cerrarDialogo = () => {
    setDialogoAbierto(false);
    setNombre("");
    setIdEditar(null);
    setRol("");
  };

  // Guardar usuario (crear o editar)
  const guardarUsuario = async () => {
    try {
      const usuario = { nombre, id_rol: rol };

      if (idEditar) {
        await editarUsuario(idEditar, usuario);
      } else {
        await crearUsuario(usuario);
      }
      cargarUsuarios();
      cerrarDialogo();
    } catch (error) {
      console.error("Error al guardar usuario:", error);
    }
  };

  // Eliminar usuarios
  const eliminarUsuarioReact = async (id) => {
    try {
      await eliminarUsuario(id);
      cargarUsuarios();
    } catch (error) {
      console.error("Error al eliminar usuario:", error);
    }
  };

  return (
    <Box>
      <Typography variant="h5" mb={2}>
        Usuarios
      </Typography>
      <Button
        variant="contained"
        color="primary"
        onClick={() => abrirDialogo()}
      >
        Nuevo Usuario
      </Button>

      <TableContainer component={Paper} sx={{ mt: 2 }}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>ID</TableCell>
              <TableCell>Nombre</TableCell>
              <TableCell>Rol</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {usuarios.map((forma) => (
              <TableRow key={forma.id_usuario}>
                <TableCell>{forma.id_usuario}</TableCell>
                <TableCell>{forma.nombre}</TableCell>
                <TableCell>
                  {
                    roles.find((r) => r.id_rol === forma.id_rol)?.desc_rol ||
                    forma.id_rol
                  }
                </TableCell>
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
                    onClick={() => eliminarUsuarioReact(forma.id_usuario)}
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
          {idEditar ? "Editar usuario" : "Nuevo usuario"}
        </DialogTitle>
        <DialogContent>
          <TextField
            label="Nombre"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
            fullWidth
            sx={{ mt: 1 }}
          />

          <FormControl fullWidth sx={{ mt: 2 }}>
            <InputLabel id="rol-label">Rol</InputLabel>
            <Select
              labelId="rol-label"
              value={rol}
              onChange={(e) => setRol(e.target.value)}
              label="Rol"
            >
              {roles.map((r) => (
                <MenuItem key={r.id_rol} value={r.id_rol}>
                  {r.desc_rol}
                </MenuItem>
              ))}
            </Select>
          </FormControl>
        </DialogContent>
        <DialogActions>
          <Button onClick={cerrarDialogo}>Cancelar</Button>
          <Button
            onClick={guardarUsuario}
            variant="contained"
            color="primary"
          >
            Guardar
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}

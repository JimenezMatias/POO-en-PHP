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
import {
  listarProveedores,
  crearProveedor,
  editarProveedor,
  eliminarProveedor,
} from "../servicios/proveedoresService";

export default function Proveedores() {
  // Estado de la tabla
  const [proveedores, setProveedores] = useState([]);

  // Estado del diálogo
  const [dialogoAbierto, setDialogoAbierto] = useState(false);
  const [idEditar, setIdEditar] = useState(null);

  // Campos del proveedor
  const [razonSocial, setRazonSocial] = useState("");
  const [domicilio, setDomicilio] = useState("");
  const [telefono, setTelefono] = useState("");
  const [mail, setMail] = useState("");
  const [celular, setCelular] = useState("");
  const [obsv, setObsv] = useState("");

  // Cargar proveedores
  const cargarProveedores = async () => {
    try {
      const datos = await listarProveedores();
      setProveedores(datos);
    } catch (error) {
      console.error("Error al cargar proveedores:", error);
    }
  };

  useEffect(() => {
    cargarProveedores();
  }, []);

  // Abrir diálogo
  const abrirDialogo = (prov = null) => {
    if (prov) {
      setIdEditar(prov.id_proveedor);
      setRazonSocial(prov.razon_social);
      setDomicilio(prov.domicilio);
      setTelefono(prov.telefono);
      setMail(prov.mail);
      setCelular(prov.celular);
      setObsv(prov.obsv);
    } else {
      setIdEditar(null);
      setRazonSocial("");
      setDomicilio("");
      setTelefono("");
      setMail("");
      setCelular("");
      setObsv("");
    }
    setDialogoAbierto(true);
  };

  // Cerrar diálogo
  const cerrarDialogo = () => {
    setDialogoAbierto(false);
    setIdEditar(null);
    setRazonSocial("");
    setDomicilio("");
    setTelefono("");
    setMail("");
    setCelular("");
    setObsv("");
  };

  // Guardar proveedor
  const guardarProveedor = async () => {
    try {
      const proveedor = {
        razon_social: razonSocial,
        domicilio,
        telefono,
        mail,
        celular,
        obsv,
      };

      if (idEditar) {
        await editarProveedor(idEditar, proveedor);
      } else {
        await crearProveedor(proveedor);
      }

      cargarProveedores();
      cerrarDialogo();
    } catch (error) {
      console.error("Error al guardar proveedor:", error);
    }
  };

  // Eliminar proveedor
  const eliminarProv = async (id) => {
    try {
      await eliminarProveedor(id);
      cargarProveedores();
    } catch (error) {
      console.error("Error al eliminar proveedor:", error);
    }
  };

  return (
    <Box>
      <Typography variant="h5" mb={2}>
        Proveedores
      </Typography>
      <Button variant="contained" color="primary" onClick={() => abrirDialogo()}>
        Nuevo Proveedor
      </Button>

      <TableContainer component={Paper} sx={{ mt: 2 }}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell>ID</TableCell>
              <TableCell>Razón Social</TableCell>
              <TableCell>Domicilio</TableCell>
              <TableCell>Teléfono</TableCell>
              <TableCell>Mail</TableCell>
              <TableCell>Celular</TableCell>
              <TableCell>Observaciones</TableCell>
              <TableCell>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {proveedores.map((prov) => (
              <TableRow key={prov.id_proveedor}>
                <TableCell>{prov.id_proveedor}</TableCell>
                <TableCell>{prov.razon_social}</TableCell>
                <TableCell>{prov.domicilio}</TableCell>
                <TableCell>{prov.telefono}</TableCell>
                <TableCell>{prov.mail}</TableCell>
                <TableCell>{prov.celular}</TableCell>
                <TableCell>{prov.obsv}</TableCell>
                <TableCell>
                  <Button
                    variant="outlined"
                    color="secondary"
                    onClick={() => abrirDialogo(prov)}
                    sx={{ mr: 1 }}
                  >
                    Editar
                  </Button>
                  <Button
                    variant="outlined"
                    color="error"
                    onClick={() => eliminarProv(prov.id_proveedor)}
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
        <DialogTitle>{idEditar ? "Editar Proveedor" : "Nuevo Proveedor"}</DialogTitle>
        <DialogContent>
          <TextField
            label="Razón Social"
            value={razonSocial}
            onChange={(e) => setRazonSocial(e.target.value)}
            fullWidth
            sx={{ mt: 1 }}
          />
          <TextField
            label="Domicilio"
            value={domicilio}
            onChange={(e) => setDomicilio(e.target.value)}
            fullWidth
            sx={{ mt: 2 }}
          />
          <TextField
            label="Teléfono"
            value={telefono}
            onChange={(e) => setTelefono(e.target.value)}
            fullWidth
            sx={{ mt: 2 }}
          />
          <TextField
            label="Mail"
            value={mail}
            onChange={(e) => setMail(e.target.value)}
            fullWidth
            sx={{ mt: 2 }}
          />
          <TextField
            label="Celular"
            value={celular}
            onChange={(e) => setCelular(e.target.value)}
            fullWidth
            sx={{ mt: 2 }}
          />
          <TextField
            label="Observaciones"
            value={obsv}
            onChange={(e) => setObsv(e.target.value)}
            fullWidth
            multiline
            rows={3}
            sx={{ mt: 2 }}
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={cerrarDialogo}>Cancelar</Button>
          <Button onClick={guardarProveedor} variant="contained" color="primary">
            Guardar
          </Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
}

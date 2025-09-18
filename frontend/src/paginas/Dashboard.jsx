import { useEffect, useState} from "react";
import React from "react";
import { Outlet, useNavigate } from 'react-router-dom';
import { getToken } from "../servicios/authService";
import {
  Button,
  Box,
  Drawer,
  List,
  ListItem,
  ListItemText,
  Menu,
  MenuItem,
} from "@mui/material";
import logoNegocio from '../assets/logo-comercio.png';

const drawerWidth = 220;
function Dashboard() {
  const token = getToken(); // token guardado en localStorage

  // Para manejar los menús desplegables
  const [anchorEl, setAnchorEl] = useState(null);
  const [activeMenu, setActiveMenu] = useState('');
  const navigate = useNavigate();

  // Opciones personalizadas por botón
  
  const menuOptions = {
    Archivo: [
      { label: 'Formas De Pago', path: 'formasDePago' },
      { label: 'Localidades', path: 'localidades' },
      { label: 'Proveedores', path: 'proveedores' },
      { label: 'Rubros', path: 'rubros' },
      { label: 'Ubicaciones', path: 'ubicaciones' },
      { label: 'Usuarios', path: 'usuarios' },
      { label: 'WS', path: 'ws' }
    ],
    Mantenimiento: [
      { label: 'nada', path: 'nada' }
    ],
    CuentasCorrientes: [
      { label: 'nada', path: 'nada' }
    ],
    Cajas: [
      { label: 'nada', path: 'nada' }
    ],
    Precios: [
      { label: 'nada', path: 'nada' }
    ],
    // ...otros menús
  };

  const drawerItems = [
    { label: 'STOCK', path: 'stock' },
    { label: 'ARTICULOS', path: 'articulos' },
    { label: 'VENTAS (F5)', path: 'ventas' },
    { label: 'CONSULTA DE VENTAS', path: 'consulta-ventas' },
    { label: 'CLIENTES', path: 'clientes' },
    { label: 'CONSULTA CF', path: 'consulta-cf' },
    { label: 'EGRESOS', path: 'egresos' },
    { label: 'BACKUP', path: 'backup' },
    { label: 'NOTAS DE CREDITO', path: 'notas-credito' },
    { label: 'SALIR', path: 'logout' }
  ];

  const handleDrawerClick = (path) => {
    navigate(path);
  };


  const handleMenuOpen = (event, menuKey) => {
    setAnchorEl(event.currentTarget);
    setActiveMenu(menuKey);
  };

  const handleMenuClose = () => {
    setAnchorEl(null);
    setActiveMenu('');
  };

  const handleMenuItemClick = (path) => {
    handleMenuClose();
    navigate(path);
  };

  // useEffect(() => {
  //   const fetchDashboard = async () => {
  //     if (!token) return;

  //     try {
  //       const res = await fetch("http://localhost/protegido/dashboard", {
  //         method: "GET",
  //         headers: {
  //           "Authorization": `Bearer ${token}`,
  //         },
  //       });

  //       const data = await res.json();

  //       if (res.ok) {
  //         setMessage(data.message); // mostramos mensaje del backend
  //       } else {
  //         setMessage(data.error || "No autorizado");
  //         // Opcional: redirigir a login si no autorizado
  //         window.location.href = "/login";
  //       }
  //     } catch (err) {
  //       console.error(err);
  //       setMessage("Error de conexión con el servidor");
  //     }
  //   };

  //   fetchDashboard();
  // }, [token]);

  return (
    <Box sx={{ display: 'flex', height: '100vh' }}>
      {/* Drawer fijo a la izquierda */}
      <Drawer
        variant="permanent"
        sx={{
          width: drawerWidth,
          flexShrink: 0,
          '& .MuiDrawer-paper': { width: drawerWidth, boxSizing: 'border-box' },
        }}
      >
        {/* Imagen del negocio */}
        <Box sx={{ width: '100%', height: 220, display: 'flex', justifyContent: 'center' }}>
          <img
            src={logoNegocio} // Reemplazá con tu ruta o URL
            alt="Logo del negocio"
            style={{ width: '110px', height: 'auto', objectFit: 'contain' }}
          />
        </Box>
        <List sx={{ cursor: 'pointer' }}>
          {drawerItems.map(({ label, path }) => (
            <ListItem
              button
              key={label}
              onClick={() => handleDrawerClick(path)}
              sx={{
                color: 'black',
                borderRadius: '90px',
                transition: 'transform 0.2s ease-in-out',
                '&:hover': {
                  backgroundColor: '#000000',
                  color: 'white',
                  transform: 'scale(1.01)'
                }
              }}
              >
              <ListItemText
               primary={label}
              primaryTypographyProps={{ fontSize: '0.90rem' }} 
               />
            </ListItem>
          ))}
        </List>
      </Drawer>

      {/* Contenedor derecho */}
      <Box sx={{ flexGrow: 1, display: 'flex', flexDirection: 'column' }}>
        {/* Barra superior con botones */}
        <Box sx={{ display: 'flex', alignItems: 'center', p: 2, borderBottom: '1px solid #ccc', gap: 2 }}>
          
          {/* Botones que abren menús */}
          {Object.keys(menuOptions).map((label) => (
            <Button 
              key={label} 
              onClick={(e) => handleMenuOpen(e, label)}
              sx={{
                color: 'black',
                borderRadius: '50px',
                textTransform: 'none', // evita que el texto se vuelva mayúscula
                fontSize: '0.99rem',
                transition: 'transform 0.2s ease-in-out',
                '&:hover': {
                  backgroundColor: '#000000',
                  color: 'white',
                  transform: 'scale(1.03)'
                }
              }}
            >
              {label}
            </Button>
          ))}

          {/* Menú desplegable */}
          <Menu anchorEl={anchorEl} open={Boolean(anchorEl)} onClose={handleMenuClose}>
            {menuOptions[activeMenu]?.map((option, index) => (
              <MenuItem 
                key={index}
                onClick={() => handleMenuItemClick(option.path)}
                sx={{
                  color: 'black',
                  borderRadius: '120px',
                  transition: 'transform 0.2s ease-in-out',
                  fontSize: '0.90rem',
                  '&:hover': {
                    backgroundColor: '#000000',
                    color: 'white',
                    transform: 'scale(1.01)'
                  }
                }}
              >
                {option.label}
              </MenuItem>
            ))}
          </Menu>
        </Box>

        {/* Contenido principal */}
        <Box sx={{ flexGrow: 1, p: 3 }}>
          <Outlet />
        </Box>
      </Box>
    </Box>
  );
}

export default Dashboard;

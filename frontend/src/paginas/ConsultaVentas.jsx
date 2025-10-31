import React, { useState, useEffect } from 'react';
import {
  Box, Paper, Typography, Button, Table, TableBody, 
  TableCell, TableHead, TableRow, TableContainer, Alert
} from '@mui/material';
import { DatePicker } from '@mui/x-date-pickers';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import dayjs from 'dayjs';
import { 
  consultarVentas, 
  consultarTodasVentas, 
  consultarVentasHoy,
  obtenerDetalleVenta,
  resumenFormasPago,
  resumenTodasFormasPago,
  resumenFormasPagoHoy
} from '../servicios/consultaVentasService';

const ConsultaVentas = () => {
  // Estados
  const [ventas, setVentas] = useState([]);
  const [ventaSeleccionada, setVentaSeleccionada] = useState(null);
  const [detalleVenta, setDetalleVenta] = useState([]);
  const [resumenFormasPagoData, setResumenFormasPagoData] = useState([]);
  const [fechaDesde, setFechaDesde] = useState(dayjs().startOf('month'));
  const [fechaHasta, setFechaHasta] = useState(dayjs());
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  // Funciones
  const handleFiltrar = async () => {
    setLoading(true);
    setError(null);
    // Limpiar venta seleccionada y detalle al cambiar filtros
    setVentaSeleccionada(null);
    setDetalleVenta([]);
    try {
      // Validar que las fechas sean válidas
      if (!fechaDesde || !fechaHasta) {
        setError('Por favor seleccione ambas fechas');
        setLoading(false);
        return;
      }

      // Formatear fechas a YYYY-MM-DD
      const desde = fechaDesde.isValid() ? fechaDesde.format('YYYY-MM-DD') : '';
      const hasta = fechaHasta.isValid() ? fechaHasta.format('YYYY-MM-DD') : '';
      
      if (!desde || !hasta) {
        setError('Las fechas seleccionadas no son válidas');
        setLoading(false);
        return;
      }
      
      console.log('🔍 Filtrando ventas desde:', desde, 'hasta:', hasta);
      
      const [ventasData, resumenData] = await Promise.all([
        consultarVentas(desde, hasta),
        resumenFormasPago(desde, hasta)
      ]);
      
      console.log('✅ Datos recibidos:', { ventas: ventasData.length, resumen: resumenData.length });
      
      setVentas(ventasData);
      setResumenFormasPagoData(resumenData);
    } catch (error) {
      console.error('❌ Error al filtrar:', error);
      setError('Error al filtrar ventas: ' + error.message);
    } finally {
      setLoading(false);
    }
  };

  const handleTodasLasVentas = async () => {
    setLoading(true);
    setError(null);
    // Limpiar venta seleccionada y detalle al cambiar filtros
    setVentaSeleccionada(null);
    setDetalleVenta([]);
    try {
      console.log('🔍 Cargando todas las ventas...');
      
      const [ventasData, resumenData] = await Promise.all([
        consultarTodasVentas(),
        resumenTodasFormasPago()
      ]);
      
      console.log('✅ Todas las ventas cargadas:', { ventas: ventasData.length, resumen: resumenData.length });
      
      setVentas(ventasData);
      setResumenFormasPagoData(resumenData);
    } catch (error) {
      console.error('❌ Error al cargar todas las ventas:', error);
      setError('Error al cargar todas las ventas: ' + error.message);
    } finally {
      setLoading(false);
    }
  };

  const handleHoy = async () => {
    setLoading(true);
    setError(null);
    // Limpiar venta seleccionada y detalle al cambiar filtros
    setVentaSeleccionada(null);
    setDetalleVenta([]);
    try {
      const hoy = dayjs().format('YYYY-MM-DD');
      console.log('🔍 Cargando ventas de hoy:', hoy);
      
      const [ventasData, resumenData] = await Promise.all([
        consultarVentasHoy(hoy),
        resumenFormasPagoHoy(hoy)
      ]);
      
      console.log('✅ Ventas de hoy cargadas:', { ventas: ventasData.length, resumen: resumenData.length });
      
      setVentas(ventasData);
      setResumenFormasPagoData(resumenData);
    } catch (error) {
      console.error('❌ Error al cargar ventas de hoy:', error);
      setError('Error al cargar ventas de hoy: ' + error.message);
    } finally {
      setLoading(false);
    }
  };

  const handleVentaClick = async (venta) => {
    setVentaSeleccionada(venta);
    setError(null);
    try {
      console.log('🔍 Cargando detalle de venta:', venta.ID);
      
      const detalle = await obtenerDetalleVenta(venta.ID);
      console.log('✅ Detalle cargado:', detalle.length, 'productos');
      
      setDetalleVenta(detalle);
    } catch (error) {
      console.error('❌ Error al cargar detalle:', error);
      setError('Error al cargar detalle de venta: ' + error.message);
    }
  };

  const exportarExcel = () => {
    console.log('📊 Exportar Excel - Implementar');
    // TODO: Implementar exportación a Excel
  };

  const reimprimirComprobante = () => {
    if (ventaSeleccionada) {
      console.log('🖨️ Re-imprimir comprobante:', ventaSeleccionada.ID);
      // TODO: Implementar re-impresión
    }
  };

  // Cargar datos iniciales solo si las fechas son válidas
  useEffect(() => {
    // Esperar un momento para que los date pickers se inicialicen
    const timer = setTimeout(() => {
      if (fechaDesde && fechaHasta && fechaDesde.isValid() && fechaHasta.isValid()) {
        console.log('🚀 ConsultaVentas montado, cargando datos iniciales...');
        handleFiltrar();
      }
    }, 100);
    
    return () => clearTimeout(timer);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  return (
    <LocalizationProvider dateAdapter={AdapterDayjs}>
      <Box sx={{ p: 2, height: 'calc(100vh - 100px)' }}>
        <Typography variant="h4" sx={{ mb: 2 }}>
          CONSULTA DE VENTAS
        </Typography>

        {/* Error Alert */}
        {error && (
          <Alert severity="error" sx={{ mb: 2 }} onClose={() => setError(null)}>
            {error}
          </Alert>
        )}

        {/* Layout principal con Box */}
        <Box sx={{ display: 'flex', gap: 2, height: 'calc(100% - 200px)' }}>
          {/* Columna izquierda - Tablas */}
          <Box sx={{ flex: '2', display: 'flex', flexDirection: 'column', gap: 2 }}>
            {/* Tabla Ventas */}
            <Paper sx={{ flex: '1', overflow: 'auto' }}>
              <Typography variant="h6" sx={{ p: 1, bgcolor: 'grey.200', fontWeight: 'bold' }}>
                VENTAS
              </Typography>
              <TableContainer sx={{ height: 'calc(100% - 48px)' }}>
                <Table stickyHeader size="small">
                  <TableHead>
                    <TableRow>
                      <TableCell sx={{ fontWeight: 'bold' }}>ID</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>FECHA_HORA</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>IMPORTE</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>USUARIO</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>FORMA_PAGO</TableCell>
                    </TableRow>
                  </TableHead>
                  <TableBody>
                    {ventas.length === 0 ? (
                      <TableRow>
                        <TableCell colSpan={5} align="center" sx={{ py: 4 }}>
                          {loading ? 'Cargando...' : 'No hay ventas para mostrar'}
                        </TableCell>
                      </TableRow>
                    ) : (
                      ventas.map((venta) => (
                        <TableRow 
                          key={venta.ID}
                          hover
                          onClick={() => handleVentaClick(venta)}
                          sx={{ 
                            cursor: 'pointer',
                            '&:hover': { bgcolor: 'action.hover' }
                          }}
                        >
                          <TableCell>{venta.ID}</TableCell>
                          <TableCell>{venta.FECHA_HORA}</TableCell>
                          <TableCell>${parseFloat(venta.IMPORTE).toFixed(2)}</TableCell>
                          <TableCell>{venta.USUARIO}</TableCell>
                          <TableCell>{venta.FORMA_PAGO}</TableCell>
                        </TableRow>
                      ))
                    )}
                  </TableBody>
                </Table>
              </TableContainer>
            </Paper>

            {/* Tabla Detalle */}
            <Paper sx={{ flex: '1', overflow: 'auto' }}>
              <Typography variant="h6" sx={{ p: 1, bgcolor: 'grey.200', fontWeight: 'bold' }}>
                DETALLE {ventaSeleccionada && `- Venta #${ventaSeleccionada.ID}`}
              </Typography>
              <TableContainer sx={{ height: 'calc(100% - 48px)' }}>
                <Table stickyHeader size="small">
                  <TableHead>
                    <TableRow>
                      <TableCell sx={{ fontWeight: 'bold' }}>ID</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>CODIGO</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>DETALLE</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>CANTIDAD</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>PRECIO_UNITARIO</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>IMPORTE</TableCell>
                    </TableRow>
                  </TableHead>
                  <TableBody>
                    {detalleVenta.length === 0 ? (
                      <TableRow>
                        <TableCell colSpan={6} align="center" sx={{ py: 4 }}>
                          {ventaSeleccionada ? 'Cargando detalle...' : 'Selecciona una venta para ver el detalle'}
                        </TableCell>
                      </TableRow>
                    ) : (
                      detalleVenta.map((item, index) => (
                        <TableRow key={index}>
                          <TableCell>{item.ID}</TableCell>
                          <TableCell>{item.CODIGO}</TableCell>
                          <TableCell>{item.DETALLE}</TableCell>
                          <TableCell>{parseFloat(item.CANTIDAD).toFixed(4)}</TableCell>
                          <TableCell>${parseFloat(item.PRECIO_UNITARIO).toFixed(2)}</TableCell>
                          <TableCell>${parseFloat(item.IMPORTE).toFixed(2)}</TableCell>
                        </TableRow>
                      ))
                    )}
                  </TableBody>
                </Table>
              </TableContainer>
            </Paper>
          </Box>

          {/* Columna derecha - Resumen */}
          <Box sx={{ flex: '1', minWidth: '300px' }}>
            <Paper sx={{ p: 2, height: '100%', overflow: 'auto' }}>
              <Typography variant="h6" sx={{ mb: 2, fontWeight: 'bold' }}>
                RESUMEN POR FORMA DE PAGO
              </Typography>
              
              <TableContainer>
                <Table size="small">
                  <TableHead>
                    <TableRow>
                      <TableCell sx={{ fontWeight: 'bold' }}>FORMA_PAGO</TableCell>
                      <TableCell sx={{ fontWeight: 'bold' }}>TOTAL</TableCell>
                    </TableRow>
                  </TableHead>
                  <TableBody>
                    {resumenFormasPagoData.length === 0 ? (
                      <TableRow>
                        <TableCell colSpan={2} align="center" sx={{ py: 2 }}>
                          {loading ? 'Cargando...' : 'No hay datos'}
                        </TableCell>
                      </TableRow>
                    ) : (
                      resumenFormasPagoData.map((item, index) => (
                        <TableRow key={index}>
                          <TableCell>{item.FORMA_PAGO}</TableCell>
                          <TableCell sx={{ fontWeight: 'bold' }}>
                            ${parseFloat(item.TOTAL).toFixed(2)}
                          </TableCell>
                        </TableRow>
                      ))
                    )}
                  </TableBody>
                </Table>
              </TableContainer>

              {/* Total General */}
              <Box sx={{ mt: 2, p: 2, bgcolor: 'primary.light', borderRadius: 1 }}>
                <Typography variant="h6" sx={{ color: 'white', fontWeight: 'bold' }}>
                  TOTAL GENERAL: ${resumenFormasPagoData.reduce((sum, item) => sum + parseFloat(item.TOTAL || 0), 0).toFixed(2)}
                </Typography>
              </Box>
            </Paper>
          </Box>
        </Box>

        {/* Panel de Control */}
        <Paper sx={{ p: 2, mt: 2 }}>
          <Box sx={{ display: 'flex', gap: 2, alignItems: 'center', flexWrap: 'wrap' }}>
            <DatePicker 
              label="Desde" 
              value={fechaDesde} 
              onChange={setFechaDesde}
              format="DD-MM-YYYY"
              size="small"
            />
            <DatePicker 
              label="Hasta" 
              value={fechaHasta} 
              onChange={setFechaHasta}
              format="DD-MM-YYYY"
              size="small"
            />
            <Button 
              variant="contained" 
              onClick={handleFiltrar}
              disabled={loading}
              size="small"
            >
              {loading ? 'Filtrando...' : 'Filtrar'}
            </Button>
            <Button 
              variant="outlined" 
              onClick={handleTodasLasVentas}
              disabled={loading}
              size="small"
            >
              Todas
            </Button>
            <Button 
              variant="outlined" 
              onClick={handleHoy}
              disabled={loading}
              size="small"
            >
              Hoy
            </Button>
          </Box>
        </Paper>

        {/* Botones inferiores */}
        <Box sx={{ display: 'flex', gap: 2, mt: 2 }}>
          <Button variant="outlined" onClick={exportarExcel} size="small">
            📊 Excel
          </Button>
          <Button 
            variant="outlined" 
            onClick={reimprimirComprobante}
            disabled={!ventaSeleccionada}
            size="small"
          >
            🖨️ Re-Imprimir Comprobante
          </Button>
        </Box>
      </Box>
    </LocalizationProvider>
  );
};

export default ConsultaVentas;
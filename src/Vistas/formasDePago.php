<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>FormasDePago</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      
    }
  </style>
</head>
<body>

  <div class="container-nav">
    <section class="sidebar-section">
      <div class="Imagen-PuntoDeVenta">
        <img src="assets/img/logoComercio.jpg" alt="Logo Punto de Venta">
      </div>
      
      <div class="sidebar">
        <a href="/stock">Stock</a>
        <a href="/articulos">Artículos</a>
        <a href="/ventas">Ventas</a>
        <a href="/consultar-ventas">Consulta de Ventas</a>
        <a href="#" id="btn-clientes">Clientes</a>
        <a href="/consulta-cf">Consulta CF</a>
        <a href="/egresos">Egresos</a>
        <a href="/backup">Backup</a>
        <a href="/notas-credito">Notas de Crédito</a>
        <a href="/logout">Salir</a>
      </div>

      <div class="">
        <p>Footer sidebar</p>
      </div>

    </section>

    <nav class="navbar">
      <div class="menu-container">
        <!-- Botón Archivos -->
        <div class="dropdown">
          <button id="menu-toggle-archivos" class="menu-btn">Archivos</button>
          <div id="dropdown-menu-archivos" class="dropdown-menu">
            <a href="#">Nuevo</a>
            <a href="#">Abrir</a>
            <a href="#">Guardar</a>
          </div>
        </div>

        <!-- Botón Opciones -->
        <div class="dropdown">
          <button id="menu-toggle-opciones" class="menu-btn">Opciones</button>
          <div id="dropdown-menu-opciones" class="dropdown-menu">
            <a href="#">Configuración</a>
            <a href="#">Preferencias</a>
          </div>
        </div>

        <!-- Botón Perfil -->
        <div class="dropdown">
          <button id="menu-toggle-perfil" class="menu-btn">Perfil</button>
          <div id="dropdown-menu-perfil" class="dropdown-menu">
            <a href="#">Mi cuenta</a>
            <a href="#">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
  
  <!-- Modal Clientes -->
  <div id="modal-clientes" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Gestión de Clientes</h2>

      <!-- Formulario para registrar -->
      <form id="form-clientes" class="modal-form-container">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Registrar</button>
      </form>

      <!-- Tabla de clientes (oculta por defecto, se mostrará al editar) -->
      <table id="tabla-clientes" class="tabla-clientes">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargarán los clientes con JS -->
          <tr>
            <td>1</td>
            <td>Juan Pérez</td>
            <td>juan@example.com</td>
          </tr>
          <tr>
            <td>2</td>
            <td>María Gómez</td>
            <td>maria@example.com</td>
          </tr>
        </tbody>
      </table>

      <!-- Botones editar y eliminar -->
      <div class="acciones-clientes">
        <button id="btn-editar">Editar Cliente</button>
        <button id="btn-eliminar">Eliminar Cliente</button>
      </div>
    </div>
  </div>

  <!-- Script del modal -->
  <script src="assets/js/javascript.js"></script>

  <!-- Script para fetch y JWT del login al dashboard -->
  <script src="assets/js/dashboard.js"></script>
</body>
</html>
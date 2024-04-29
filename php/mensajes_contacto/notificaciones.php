<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página de Gestión de Productos</title>
  <!-- Estilos -->
  <link rel="stylesheet" href="../../css/normalize.css" />
  <link rel="stylesheet" href="../../css/notificaciones.css" />
  <!-- Fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Island+Moments&display=swap" rel="stylesheet" />
</head>

<body>
  <header class="header">
    <a class="header-logo" href="productos.php">
      <img src="../../img/cafe.webp" alt="cafe logo" />
      <h1>Café del bosque</h1>
    </a>
    <div class="header-links">
      <a class="link" href="productos.php">Productos</a>
      <a class="link" href="configuracion.php">Configuración</a>
      <a class="link" href="contacto.php">Contacto</a>
      <a class="link" href="../informes/historialCompras.php">Historial compras</a>
      <a class="link" href="gestion.php">Gestión de productos</a>
      <a class="link seleccionado" href="notificaciones.php">Notificaciones</a>
      <a class='link' href='../informes/ventas.php'>Informes</a>
    </div>
  </header>
  <div class="banner">
    <div class="subtitulo">
      <h2>Notificaciones</h2>
    </div>
  </div>

  <!-- Agregar la tabla para mostrar los mensajes -->
  <div class="tabla-notificaciones">
    <table>
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Mensaje</th>
          <th>Leído</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Nombre de Usuario 1</td>
          <td>Mensaje del usuario 1</td>
          <td>No</td>
          <td>
            <button class="boton-eliminar">Eliminar</button>
            <button class="boton-contestar">Contestar</button>
          </td>
        </tr>
        <tr>
          <td>Nombre de Usuario 2</td>
          <td>Mensaje del usuario 2</td>
          <td>Sí</td>
          <td>
            <button class="boton-eliminar">Eliminar</button>
            <button class="boton-contestar">Contestar</button>
          </td>
        </tr>
        <tr>
          <td>Nombre de Usuario 3</td>
          <td>Mensaje del usuario 3</td>
          <td>No</td>
          <td>
            <button class="boton-eliminar">Eliminar</button>
            <button class="boton-contestar">Contestar</button>
          </td>
        </tr>
        <!-- Puedes agregar más filas aquí si es necesario -->
      </tbody>
    </table>
  </div>
  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
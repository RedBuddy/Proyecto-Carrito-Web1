<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responder Mensaje</title>
  <!-- Estilos -->
  <link rel="stylesheet" href="../../css/normalize.css" />
  <link rel="stylesheet" href="../../css/respuesta.css" />
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

  <!-- Formulario de respuesta -->
  <div class="formulario-respuesta">
    <form action="#" method="post">
      <div class="campo">
        <label for="para">Para:</label>
        <input type="email" id="para" name="para" required />
      </div>
      <div class="campo">
        <label for="asunto">Asunto:</label>
        <input type="text" id="asunto" name="asunto" required />
      </div>
      <div class="campo">
        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="6" required></textarea>
      </div>
      <div class="botones">
        <button type="submit" class="boton-enviar">Enviar</button>
        <button type="button" class="boton-cancelar">Cancelar</button>
      </div>
    </form>
  </div>

  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
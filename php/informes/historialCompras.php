<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página de Gestión de Productos</title>
  <!-- Estilos -->
  <link rel="stylesheet" href="../../css/normalize.css" />
  <link rel="stylesheet" href="../../css/informes/historialCompras.css" />
  <!-- Fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Island+Moments&display=swap" rel="stylesheet" />
</head>

<body>
  <header class="header">
    <div class="header-logo">
      <img src="../../img/cafe.webp" alt="cafe logo" />
      <h1>Café del bosque</h1>
    </div>
    <div class="header-links">
      <a class="link seleccionado" href="productos.php">Productos</a>
      <a class="link" href="configuracion.php">Configuracion</a>
      <a class="link" href="contacto.php">Contacto</a>
      <a class="link" href="informes/historialCompras.php">Historial compras</a>
      <?php

      if (isset($_SESSION['username'])) {
        if ($_SESSION['username'] == 'admin') {
          echo "<a class='link' href='gestion_productos/gestion.php'>Gestión de productos</a>";
        }
      }

      if (isset($_SESSION['username'])) {
        $usuario = $_SESSION['username'];
        echo "<a class='link' href='editar_usuario.php'>$usuario</a>";
      } else {
        echo "<a class='link' href=''>Usuario X</a>";
      }

      $cantidadProductos = 0;
      if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
        $cantidadProductos = count($_SESSION["carrito"]);
      }
      echo "<a class='boton btn-carrito' href='carrito.php'>Carrito (<span class='boton-carrito'>{$cantidadProductos}</span>)</a>";
      ?>
    </div>
  </header>
  <div class="banner">
    <div class="subtitulo">
      <h2>Historial de Compras</h2>
    </div>
  </div>

  <div class="tabla-ventas">
    <table>
      <thead>
        <tr>
          <th>Número de Compra</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Total de Compra</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td rowspan="2">001</td>
          <td>Producto 1</td>
          <td>1</td>
          <td rowspan="2">$50.00</td>
        </tr>
        <tr>
          <td>Producto 2</td>
          <td>1</td>
        </tr>
        <tr>
          <td>002</td>
          <td>Producto 3</td>
          <td>1</td>
          <td>$30.00</td>
        </tr>
        <!-- Puedes agregar más filas aquí si es necesario -->
      </tbody>
    </table>
  </div>

  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
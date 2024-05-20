<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../../index.php");
}

// Incluir el archivo de configuración de la base de datos
require '../../includes/config/database.php';

// Establecer conexión a la base de datos
$db = conectarBD();

// Obtener el nombre de usuario de la sesión
$usuario = $_SESSION['username'];

// Consultar el historial de compras del usuario
$consulta = "SELECT ventas.ID AS NumeroCompra, detalle_venta.Producto, detalle_venta.Cantidad, ventas.Fecha, ventas.Total
             FROM ventas
             INNER JOIN detalle_venta ON ventas.ID = detalle_venta.Venta_id
             WHERE ventas.Usuario = '$usuario'";

$resultado = $db->query($consulta);

// Crear un array para almacenar temporalmente las filas agrupadas por número de compra
$filas_agrupadas = array();

while ($fila = $resultado->fetch_assoc()) {
  $numero_compra = $fila['NumeroCompra'];

  // Si aún no existe una fila para el número de compra, crearla
  if (!isset($filas_agrupadas[$numero_compra])) {
    $filas_agrupadas[$numero_compra] = array(
      'numero_compra' => $numero_compra,
      'productos' => array()
    );
  }

  // Agregar el producto a la fila correspondiente
  $filas_agrupadas[$numero_compra]['productos'][] = array(
    'producto' => $fila['Producto'],
    'cantidad' => $fila['Cantidad'],
    'fecha' => $fila['Fecha'],
    'total' => $fila['Total']
  );
}

// Cerrar la conexión a la base de datos
$db->close();

// Definir el número de elementos por página
$elementos_por_pagina = 10;

// Calcular el número total de páginas
$total_paginas = ceil(count($filas_agrupadas) / $elementos_por_pagina);

// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el índice de inicio y fin para la página actual
$indice_inicio = ($pagina_actual - 1) * $elementos_por_pagina;
$indice_fin = $indice_inicio + $elementos_por_pagina;

// Filtrar las filas agrupadas para la página actual
$filas_pagina = array_slice($filas_agrupadas, $indice_inicio, $elementos_por_pagina);
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
    <a class="header-logo" href="../productos.php">
      <img src="../../img/cafe.webp" alt="cafe logo" />
      <h1>Café del bosque</h1>
    </a>
    <div class="header-links">
<<<<<<< HEAD
      <a class="link" href="../productos.php">Productos</a>
      <a class="link" href="../configuracion.php">Configuracion</a>
      <a class="link" href="../contacto.php">Contacto</a>
      <a class="link seleccionado" href="historialCompras.php">Historial compras</a>

      <?php

      if (isset($_SESSION['username'])) {
        if ($_SESSION['username'] == 'admin') {
          echo "<a class='link' href='../administracion.php'>Administración</a>";
        }
      }

      $usuario = $_SESSION['username'];
      echo "<a class='link' href='../editar_usuario.php'>$usuario</a>";

      $cantidadProductos = 0;
      if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
        $cantidadProductos = count($_SESSION["carrito"]);
      }
      echo "<a class='boton btn-carrito' href='../carrito.php'>Carrito (<span class='boton-carrito'>{$cantidadProductos}</span>)</a>";
      ?>
=======
      <a class="link" href="../productos.php">Inicio</a>
      <a class="link" href="../gestion_productos/gestion.php">Gestión de productos</a>
      <a class="link" href="../gestion_usuarios/gestion_usuarios.php">Gestión de usuarios</a>
      <a class="link seleccionado" href="../gestion_usuarios/ventas_usuarios.php">Ventas por usuario</a>
      <a class="link" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
      <a class="link" href="ventas.php">Informes</a>
>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775
    </div>
  </header>
  <div class="banner">
    <div class="subtitulo">
<<<<<<< HEAD
      <h2>Historial de compras</h2>
=======
      <h2>Historial de ventas de <?php echo $usuario; ?></h2>
>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775
    </div>
  </div>

  <div class="paginacion">
    <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
      <?php if ($i == $pagina_actual) : ?>
        <a class="pagina-actual"><?php echo $i; ?></a>
      <?php else : ?>
        <a href="?pagina=<?php echo $i; ?>&id=<?php echo $usuario; ?>"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>

  <div class="tabla-ventas">
    <table>
      <thead>
        <tr>
          <th>Número de Compra</th>
          <th>Fecha</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Total de Compra</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($filas_pagina as $fila) : ?>
          <?php foreach ($fila['productos'] as $index => $producto) : ?>
            <tr>
              <?php if ($index === 0) : ?>
                <td rowspan="<?php echo count($fila['productos']); ?>"><?php echo $fila['numero_compra']; ?></td>
                <td rowspan="<?php echo count($fila['productos']); ?>"><?php echo $producto['fecha']; ?></td>
              <?php endif; ?>
              <td><?php echo $producto['producto']; ?></td>
              <td><?php echo $producto['cantidad']; ?></td>
              <?php if ($index === 0) : ?>
                <td rowspan="<?php echo count($fila['productos']); ?>"><?php echo '$' . $producto['total']; ?></td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="paginacion">
    <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
      <?php if ($i == $pagina_actual) : ?>
        <a class="pagina-actual"><?php echo $i; ?></a>
      <?php else : ?>
        <a href="?pagina=<?php echo $i; ?>&id=<?php echo $usuario; ?>"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>

  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
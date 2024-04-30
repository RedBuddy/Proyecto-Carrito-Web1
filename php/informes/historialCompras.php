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
$consulta = "SELECT ventas.ID AS NumeroCompra, detalle_venta.Producto, detalle_venta.Cantidad, ventas.Total
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
    'total' => $fila['Total']
  );
}

// Cerrar la conexión a la base de datos
$db->close();
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
      <a class="link" href="../productos.php">Inicio</a>
      <a class="link" href="../gestion_productos/gestion.php">Gestión de productos</a>
      <a class="link" href="../gestion_usuarios/gestion_usuarios.php">Gestión de usuarios</a>
      <a class="link" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
      <a class="link seleccionado" href="ventas.php">Informes</a>
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
        <?php foreach ($filas_agrupadas as $fila) : ?>
          <?php foreach ($fila['productos'] as $index => $producto) : ?>
            <tr>
              <?php if ($index === 0) : ?>
                <td rowspan="<?php echo count($fila['productos']); ?>"><?php echo $fila['numero_compra']; ?></td>
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

  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../../index.php");
}

if ($_SESSION['username'] != 'admin') {
  header("Location: ../productos.php");
}

// Incluir el archivo de configuración de la base de datos
require '../../includes/config/database.php';

// Establecer conexión a la base de datos
$db = conectarBD();

// Obtener las fechas y el término de búsqueda del formulario
$desde = isset($_GET['desde']) ? $_GET['desde'] : '';
$hasta = isset($_GET['hasta']) ? $_GET['hasta'] : '';
$producto_busqueda = isset($_GET['producto']) ? $_GET['producto'] : '';

// Consultar las ventas por rango de fecha y término de producto
$consulta_ventas = "SELECT ventas.ID AS NumeroVenta, detalle_venta.Producto, detalle_venta.Cantidad, ventas.Total, ventas.Fecha, ventas.Usuario
                    FROM ventas
                    INNER JOIN detalle_venta ON ventas.ID = detalle_venta.Venta_id
                    WHERE ventas.Fecha BETWEEN '$desde' AND '$hasta'";

if (!empty($producto_busqueda)) {
  $consulta_ventas .= " AND detalle_venta.Producto LIKE '%$producto_busqueda%'";
}

$resultado_ventas = $db->query($consulta_ventas);

// Crear un array para almacenar temporalmente las filas agrupadas por número de venta
$filas_agrupadas = array();

while ($fila = $resultado_ventas->fetch_assoc()) {
  $numero_venta = $fila['NumeroVenta'];

  // Si aún no existe una fila para el número de venta, crearla
  if (!isset($filas_agrupadas[$numero_venta])) {
    $filas_agrupadas[$numero_venta] = array(
      'numero_venta' => $numero_venta,
      'productos' => array()
    );
  }

  // Agregar el producto a la fila correspondiente
  $filas_agrupadas[$numero_venta]['productos'][] = array(
    'producto' => $fila['Producto'],
    'cantidad' => $fila['Cantidad'],
    'total' => $fila['Total'],
    'fecha' => $fila['Fecha'],
    'usuario' => $fila['Usuario']
  );
}

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
  <link rel="stylesheet" href="../../css/informes/ventasFecha.css" />
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
      <a class="link" href="../gestion_usuarios/ventas_usuarios.php">Ventas por usuario</a>
      <a class="link" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
      <a class="link seleccionado" href="ventas.php">Informes</a>
    </div>
  </header>
  <div class="banner">
    <div class="subtitulo">
      <h2>Ventas</h2>
    </div>
  </div>

  <!-- Botones de gestión -->
  <div class="gestion-buttons">
    <button class="link-gestion" onclick="window.location.href='ventasCantidad.php'">
      Productos vendidos por cantidad
    </button>
    <button class="link-gestion" onclick="window.location.href='productosIngresos.php'">
      Productos que generan mas ingresos
    </button>
    <button class="link-gestion" onclick="window.location.href='clientesCompras.php'">
      Clientes que compran mas productos
    </button>
    <button class="link-gestion" onclick="window.location.href='clientesIngresos.php'">
      Clientes que generan mas ingresos
    </button>
    <button class="link-gestion" onclick="window.location.href='ventasFecha.php'">
      Ventas por día, semana, mes, rango de fecha
    </button>
  </div>

  <div class="busqueda-ventas">
    <form action="ventasFecha.php" method="GET">
      <label for="desde">Desde:</label>
      <input type="date" id="desde" name="desde" value="<?php echo $desde; ?>" />
      <label for="hasta">Al:</label>
      <input type="date" id="hasta" name="hasta" value="<?php echo $hasta; ?>" />
      <label for="producto">Producto:</label>
      <input type="text" id="producto" name="producto" value="<?php echo $producto_busqueda; ?>" placeholder="Campo opcional..." />
      <button type="submit" class="boton-buscar">Buscar</button>
    </form>
  </div>

  <?php if (!empty($filas_pagina)) : ?>
    <div class="tabla-ventas">
      <table>
        <thead>
          <tr>
            <th>Número de Venta</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total de Venta</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($filas_pagina as $fila) : ?>
            <?php foreach ($fila['productos'] as $index => $producto) : ?>
              <tr>
                <?php if ($index === 0) : ?>
                  <td rowspan="<?php echo count($fila['productos']); ?>"><?php echo $fila['numero_venta']; ?></td>
                  <td rowspan="<?php echo count($fila['productos']); ?>"><?php echo $producto['usuario']; ?></td>
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
  <?php else : ?>
    <div class="alinear-parrafo">
      <p>No hay resultados para mostrar.</p>
    </div>
  <?php endif; ?>

  <div class="paginacion">
    <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
      <?php if ($i == $pagina_actual) : ?>
        <a class="pagina-actual"><?php echo $i; ?></a>
      <?php else : ?>
        <a href="?pagina=<?php echo $i; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&producto=<?php echo $producto_busqueda; ?>"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>

  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
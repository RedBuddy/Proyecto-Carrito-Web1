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

// Definir la cantidad de resultados por página
$resultados_por_pagina = 10;

// Determinar la página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el inicio del conjunto de resultados
$inicio = ($pagina_actual - 1) * $resultados_por_pagina;

// Determinar el tipo de ordenamiento
$ordenamiento = isset($_GET['orden']) ? $_GET['orden'] : 'desc';
$orden = ($ordenamiento == 'asc') ? 'ASC' : 'DESC';

// Consultar los productos que generan más ingresos
$consulta_productos = "SELECT Producto, Precio, Imagen, SUM(Cantidad) AS CantidadVendida, SUM(Cantidad * Precio) AS IngresosGenerados
                       FROM detalle_venta
                       INNER JOIN productos ON detalle_venta.Producto = productos.Nombre
                       GROUP BY Producto
                       ORDER BY IngresosGenerados $orden
                       LIMIT $inicio, $resultados_por_pagina";
$resultado_productos = $db->query($consulta_productos);

// Consultar la cantidad total de productos vendidos
$consulta_total = "SELECT COUNT(DISTINCT Producto) AS Total FROM detalle_venta";
$resultado_total = $db->query($consulta_total);
$total_productos = $resultado_total->fetch_assoc()['Total'];

// Calcular la cantidad total de páginas
$total_paginas = ceil($total_productos / $resultados_por_pagina);

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
  <link rel="stylesheet" href="../../css/informes/productosIngresos.css" />
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

  <div class="alinear">
    <!-- Paginación -->
    <div class="paginacion">
      <?php if ($total_paginas > 1) : ?>
        <?php if ($pagina_actual > 1) : ?>
          <a href="productosIngresos.php?orden=<?php echo $ordenamiento; ?>&pagina=<?php echo $pagina_actual - 1; ?>" class="boton-paginacion">&lt;</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
          <a href="productosIngresos.php?orden=<?php echo $ordenamiento; ?>&pagina=<?php echo $i; ?>" class="boton-paginacion <?php echo ($i == $pagina_actual) ? 'activo' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($pagina_actual < $total_paginas) : ?>
          <a href="productosIngresos.php?orden=<?php echo $ordenamiento; ?>&pagina=<?php echo $pagina_actual + 1; ?>" class="boton-paginacion">&gt;</a>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <div class="botones-vendidos">
      <button class="boton-vendidos" onclick="window.location.href='productosIngresos.php?orden=desc'">Más Ingresos</button>
      <button class="boton-vendidos" onclick="window.location.href='productosIngresos.php?orden=asc'">Menos Ingresos</button>
    </div>
  </div>

  <div class="tabla-ventas">
    <table>
      <thead>
        <tr>
          <th>Imagen del Producto</th>
          <th>Descripción del Producto</th>
          <th>Ingresos Generados</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($fila = $resultado_productos->fetch_assoc()) : ?>
          <tr>
            <td><img src="../<?php echo $fila['Imagen']; ?>" alt="<?php echo $fila['Producto']; ?>" /></td>
            <td><?php echo $fila['Producto']; ?></td>
            <td><?php echo $fila['IngresosGenerados']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>


  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
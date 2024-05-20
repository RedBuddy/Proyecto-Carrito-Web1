<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
}

if ($_SESSION['username'] != 'admin') {
    header("Location: ../productos.php");
}

require '../../includes/config/database.php';
$db = conectarBD();

// Consulta a la base de datos
$query = "SELECT ID, Nombre, Precio, Imagen, Activo FROM productos";
$res = mysqli_query($db, $query);

$productos = [];

if ($res->num_rows > 0) {
    // Almacenar los datos en un array
    while ($row = $res->fetch_assoc()) {
        $producto = [
            'id' => $row['ID'],
            'nombre' => $row['Nombre'],
            'precio' => $row['Precio'],
            'imagen' => $row['Imagen'],
            'activo' => $row['Activo']
        ];
        array_push($productos, $producto);
    }
}

mysqli_close($db);

// echo json_encode($productos);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página de Gestión de Productos</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="../../css/normalize.css" />
    <link rel="stylesheet" href="../../css/gestion.css" />
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
            <a class="link seleccionado" href="gestion.php">Gestión de productos</a>
            <a class="link" href="../gestion_usuarios/gestion_usuarios.php">Gestión de usuarios</a>
            <a class="link" href="../gestion_usuarios/ventas_usuarios.php">Ventas por usuario</a>
            <a class="link" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
            <a class="link" href="../informes/ventas.php">Informes</a>
        </div>
    </header>
    <div class="banner">
        <div class="subtitulo">
            <h2>Gestión de productos</h2>
        </div>
        <div class="gestion-links-cont">
            <div class="gestion-links">
                <a class="link-gestion" href="agregar_producto.php">Agregar producto</a>
                <a class="link-gestion" href="baja_producto.php">Alta/Baja producto</a>
                <a class="link-gestion" href="modificar_producto.php">Modificar producto</a>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['producto_editado'])) {
        echo "<p id='alerta_verde'>{$_SESSION['producto_editado']}</p>";
        unset($_SESSION['producto_editado']);
    } ?>

    <?php if (isset($_SESSION['producto_editado_error'])) {
        echo "<p id='alerta_roja'>{$_SESSION['producto_editado_error']}</p>";
        unset($_SESSION['producto_editado_error']);
    } ?>

    <!-- Barra de búsqueda -->
    <form class="search-bar">
        <input type="text" id="filtro" placeholder="Buscar producto..." />
        <button type="submit">Borrar</button>
    </form>

    <div class="lista-productos" id="lista-productos">
        <?php foreach ($productos as $producto) : ?>
            <div class="product-item" data-nombre="<?php echo strtolower($producto['nombre']); ?>">
                <img src="../<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" />
                <div class="product-item-details">
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p>Precio: $<?php echo $producto['precio']; ?></p>
                    <a class="edit-button" href="editar_producto.php?id=<?php echo $producto['id']; ?>">Modificar</a> <!-- Enlace de modificar -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <script>
        document.getElementById('filtro').addEventListener('input', function() {
            var filtro = document.getElementById('filtro').value.toLowerCase();
            var productos = document.querySelectorAll('.lista-productos .product-item');
            productos.forEach(function(producto) {
                var nombre = producto.dataset.nombre.toLowerCase();
                if (nombre.includes(filtro)) {
                    producto.style.display = 'flex'; // Mostrar elementos que coinciden con el filtro
                } else {
                    producto.style.display = 'none'; // Ocultar elementos que no coinciden con el filtro
                }
            });
        });
    </script>

    <script src="../../js/configuracion.js"></script>
</body>

</html>
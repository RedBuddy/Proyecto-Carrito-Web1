<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}

require '../includes/config/database.php';
$db = conectarBD();

// Paginación
$porPagina = 6;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $porPagina - $porPagina) : 0;

// Consulta a la base de datos con paginación y búsqueda
$termino_busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$query = "SELECT p.ID, p.Nombre, p.Precio, p.Imagen, a.Stock
          FROM productos p
          INNER JOIN almacen a ON p.ID = a.ProductoID
          WHERE a.Stock > 0 AND p.Activo = 1";
if (!empty($termino_busqueda)) {
    $query .= " AND p.Nombre LIKE '%$termino_busqueda%'";
}
$query .= " LIMIT $inicio, $porPagina";

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
            'stock' => $row['Stock']
        ];
        array_push($productos, $producto);
    }
}

if (!$res) {
    echo "<script>console.log('Error al buscar productos en la BD');</script>";
}

// Verificar si se ha enviado el formulario para agregar al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $productoId = $_POST["producto_id"];
    $cantidad = 1;

    $nombre_selec = '';
    $precio_elec = '';
    $imagen_elec = '';
    $stock_elec = '';

    foreach ($productos as $producto) {
        if ($producto['id'] === $productoId) {
            $nombre_selec = $producto["nombre"];
            $precio_elec =  $producto["precio"];
            $imagen_elec =  $producto["imagen"];
            $stock_elec =  $producto["stock"];
            break;
        }
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION["carrito"][$productoId])) {
        $_SESSION["carrito"][$productoId]["cantidad"] += $cantidad;
    } else {
        // Agregar el producto al carrito
        $_SESSION["carrito"][$productoId] = [
            "id" => $productoId,
            "nombre" => $nombre_selec,
            "precio" =>  $precio_elec,
            "imagen" => $imagen_elec,
            "stock" => $stock_elec,
            "cantidad" => $cantidad
        ];
    }

    mysqli_close($db);
    header("Location: {$_SERVER['PHP_SELF']}?pagina=$pagina");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Tareas</title>

    <!-- Preload -->
    <!-- <link rel="preload" href="../css/normalize.css" as="style">
    <link rel="stylesheet" href="../css/normalize.css"> -->

    <link rel="preload" href="../css/productos.css" as="style">
    <link rel="stylesheet" href="../css/productos.css">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Island+Moments&display=swap" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="header-logo">
            <img src="../img/cafe.webp" alt="cafe logo">
            <h1>Café del bosque</h1>
        </div>

        <div class="header-links">
            <a class="link seleccionado" href="productos.php">Productos</a>
            <a class="link" href="configuracion.php">Configuracion</a>
            <a class="link" href="contacto.php">Contacto</a>
            <?php

            if (isset($_SESSION['username'])) {
                if ($_SESSION['username'] == 'admin') {
                    echo "<a class='link' href='gestion_productos/gestion.php'>Gestión de productos</a>";
                }
            }

            echo "<div id='elemento'>";
            if (isset($_SESSION['username'])) {
                $usuario = $_SESSION['username'];
                echo "<a class='link' href='editar_usuario.php'>$usuario</a>";
            } else {
                echo "<a class='link' href=''>Usuario X</a>";
            }
            echo "<button id='cerrar-sesion' href=''>Cerrar sesión</button>";

            echo "</div>";

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
            <h2>Productos</h2>
        </div>
        <form class="form-buscar">
            <input class="input-buscar" id="filtro" type="text" name="buscar" placeholder="Buscar producto...">
            <button class="btn-buscar" type="submit">Buscar</button>
        </form>
    </div>

    <div class="paginacion">
        <?php
        $query_total = "SELECT COUNT(*) AS total FROM productos p INNER JOIN almacen a ON p.ID = a.ProductoID WHERE a.Stock > 0 AND p.Activo = 1";
        $res_total = mysqli_query($db, $query_total);
        $total_productos = mysqli_fetch_assoc($res_total)['total'];
        $total_paginas = ceil($total_productos / $porPagina);

        // Pagina anterior
        $pagina_anterior = $pagina - 1;
        if ($pagina_anterior > 0) {
            echo "<a href='{$_SERVER['PHP_SELF']}?pagina=$pagina_anterior'>&laquo; Anterior</a>";
        }

        // Paginas numeradas
        for ($i = 1; $i <= $total_paginas; $i++) {
            $clase_pagina = ($i == $pagina) ? 'pagina-actual' : ''; // Añade la clase 'pagina-actual' si es la página actual
            echo "<a class='$clase_pagina' href='{$_SERVER['PHP_SELF']}?pagina=$i'>$i</a>";
        }

        // Pagina siguiente
        $pagina_siguiente = $pagina + 1;
        if ($pagina_siguiente <= $total_paginas) {
            echo "<a href='{$_SERVER['PHP_SELF']}?pagina=$pagina_siguiente'>Siguiente &raquo;</a>";
        }
        ?>
    </div>



    <div class="contenedor-centrado">
        <ul class="contenedor-productos" id="lista-productos">
            <?php foreach ($productos as $producto) : ?>
                <li data-nombre="<?php echo strtolower($producto['nombre']); ?>">
                    <div class="producto">
                        <div class="cont-img">
                            <img src="<?php echo $producto['imagen']; ?>" alt="imagen producto">
                        </div>
                        <h3 class="titulo-producto"><?php echo $producto['nombre']; ?></h3>
                        <h3 class="stock-producto">Disponibles: <span><?php echo $producto['stock']; ?></span></h3>
                        <div class="cont-precio-boton">
                            <h3 class="precio-producto">$<?php echo $producto['precio']; ?> / pz</h3>
                            <form method="post" action="">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <button class="agregar-carrito" type="submit" name="agregar">Agregar al carrito</button>
                            </form>

                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>



    <script>
        // Script para filtrar productos
        document.getElementById("filtro").addEventListener("submit", function() {
            var filtro = this.value.toLowerCase();
            var productos = document.querySelectorAll("#lista-productos li");
            productos.forEach(function(producto) {
                var nombre = producto.dataset.nombre;
                if (nombre.includes(filtro)) {
                    producto.style.display = "block";
                } else {
                    producto.style.display = "none";
                }
            });
        });
    </script>
</body>

<script src="../js/configuracion.js"></script>
<script src="../js/productos.js"></script>

</html>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
}

if ($_SESSION['username'] != 'admin') {
    header("Location: ../productos.php");
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
            <a class="link" href="../productos.php">Productos</a>
            <a class="link" href="../configuracion.php">Configuración</a>
            <a class="link" href="../contacto.php">Contacto</a>
            <a class="link" href="../informes/historialCompras.php">Historial compras</a>
            <a class="link seleccionado" href="gestion.php">Gestión de productos</a>
            <a class='link' href='../informes/ventas.php'>Informes</a>
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
    <?php if (isset($_SESSION['producto_agregado'])) {
        echo "<p id='alerta_verde'>{$_SESSION['producto_agregado']}</p>";
        unset($_SESSION['producto_agregado']);
    } ?>

    <?php if (isset($_SESSION['producto_agregado_error'])) {
        echo "<p id='alerta_roja'>{$_SESSION['producto_agregado_error']}</p>";
        unset($_SESSION['producto_agregado_error']);
    } ?>

    <div class="formulario">
        <form action="guardar_producto.php" method="POST" id="formularioAgregarProducto" class="formulario-agregar" enctype="multipart/form-data">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required />
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" required />
            </div>
            <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required />
            </div>
            <div>
                <label for="foto">Fotografía:</label>
                <input type="file" id="foto" name="imagen" accept="image/*" required />
            </div>
            <!-- Contenedor para mostrar la imagen seleccionada -->
            <div id="imagenSeleccionada"></div>
            <button class="boton-enviar" type="submit">Agregar</button>
        </form>
    </div>
    <script src="../../js/configuracion.js"></script>
    <script src="../../js/verificaciones.js"></script>
</body>

</html>
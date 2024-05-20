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
    <link rel="stylesheet" href="../css/normalize.css" />
    <link rel="stylesheet" href="../css/gestion.css" />
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Island+Moments&display=swap" rel="stylesheet" />
</head>

<body>
    <header class="header">
        <a class="header-logo" href="productos.php">
            <img src="../img/cafe.webp" alt="cafe logo" />
            <h1>Café del bosque</h1>
        </a>
        <div class="header-links">
            <a class="link" href="productos.php">Productos</a>
            <a class="link" href="configuracion.php">Configuración</a>
            <a class="link" href="contacto.php">Contacto</a>
            <a class="link" href="informes/historialCompras.php">Historial compras</a>
            <a class='link seleccionado' href='administracion.php'>Administración</a>
        </div>
    </header>
    <div class="banner">
        <div class="subtitulo">
            <h2>Menú de administración</h2>
        </div>
        <div class="gestion-links-cont">
            <div class="gestion-links">
                <a class="link-gestion" href="gestion_productos/gestion.php">Gestión de productos</a>
                <a class="link-gestion" href="gestion_usuarios/gestion_usuarios.php">Gestión de usuarios</a>
                <a class="link-gestion" href="gestion_usuarios/ventas_usuarios.php">Ventas por usuario</a>
                <a class="link-gestion" href="mensajes_contacto/notificaciones.php">Notificaciones</a>
                <a class="link-gestion" href="informes/ventas.php">Informes</a>
            </div>
        </div>
    </div>

    <script src="../../js/configuracion.js"></script>
    <script src="../../js/productos.js"></script>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>

    <!-- Preload -->
    <!-- <link rel="preload" href="../css/normalize.css" as="style">
    <link rel="stylesheet" href="../css/normalize.css"> -->

    <link rel="preload" href="../css/contacto.css" as="style">
    <link rel="stylesheet" href="../css/contacto.css">

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
            <a class="link" href="productos.php">Productos</a>
            <a class="link" href="configuracion.php">Configuracion</a>
            <a class="link seleccionado" href="contacto.php">Contacto</a>
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
            <h2>Sobre nosotros</h2>
        </div>
        <div class="sobre-nosotros">
            <h4>¡Bienvenido a Café del Bosque! Nos dedicamos a ofrecerte los mejores granos de café, cuidadosamente
                seleccionados de los mejores cafetales del mundo. Nuestro objetivo es brindarte una experiencia única en
                cada taza, llena de sabor y aroma. ¡Gracias por elegir Café del Bosque para disfrutar de tu café
                favorito!</h4>
        </div>
    </div>

    <?php if (isset($_SESSION['mensaje_enviado'])) {
        echo "<p id='alerta_verde'>{$_SESSION['mensaje_enviado']}</p>";
        unset($_SESSION['mensaje_enviado']);
    } ?>

    <?php if (isset($_SESSION['mensaje_error'])) {
        echo "<p id='alerta_roja'>{$_SESSION['mensaje_error']}</p>";
        unset($_SESSION['mensaje_error']);
    } ?>

    <div class="contenedor-centrado">
        <div class="redes-contacto">
            <div class="redes-elemento">
                <img src="../img/cafe.webp" alt="logo cafe">
                <h4>Correo: info@cafedelbosque.com</h4>
            </div>
            <div class="redes-elemento">
                <img src="../img/twitter.webp" alt="logo twitter">
                <h4>@CafeBosk</h4>
            </div>
            <div class="redes-elemento">
                <img src="../img/instagram.webp" alt="logo instagram">
                <h4>@CafeBosk</h4>
            </div>
        </div>
        <div class="centrar-form">
            <form class="form-contacto" action="mensajes_contacto/guardar_mensaje.php" method="POST">
                <div class="contacto-elemento">
                    <label for="nombre">Nombre:</label>
                    <input class="nombre" type="text" name="nombre" required>
                </div>
                <div class="contacto-elemento contacto-correo">
                    <label for="correo">Correo:</label>
                    <input class="correo" type="email" name="correo" required>
                </div>
                <div class="contacto-elemento contacto-mensaje">
                    <label for="mensaje">Mensaje:</label>
                    <textarea class="mensaje" id="message" name="mensaje"></textarea>
                </div>
                <div class="form-botones">
                    <button class="btn-form reset" type="reset">Reiniciar campos</button>
                    <button class="btn-form enviar" type="submit">Enviar</button>
                </div>
            </form>
        </div>

    </div>

</body>

<script src="../js/contacto.js"></script>
<script src="../js/configuracion.js"></script>
<script src="../js/productos.js"></script>


</html>
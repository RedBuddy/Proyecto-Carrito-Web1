<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pagar"])) {
    header("Location: compra.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario Registrado</title>

    <!-- Preload -->
    <link rel="preload" href="../css/normalize.css" as="style">
    <link rel="stylesheet" href="../css/normalize.css">

    <link rel="preload" href="../css/pago.css" as="style">
    <link rel="stylesheet" href="../css/pago.css">

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
        <a class="header-logo" href="productos.php">
            <img src="../img/cafe.webp" alt="cafe logo">
            <h1>Café del bosque</h1>
        </a>

        <div class="header-links">
            <a class="link" href="productos.php">Productos</a>
            <a class="link" href="configuracion.php">Configuracion</a>
            <a class="link" href="contacto.php">Contacto</a>
            <a class="link" href="informes/historialCompras.php">Historial compras</a>

            <?php

            if (isset($_SESSION['username'])) {
                if ($_SESSION['username'] == 'admin') {
                    echo "<a class='link' href='administracion.php'>Administración</a>";
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
            <h2>Productos</h2>
        </div>
    </div>

    <p id="alerta_roja" style="display: none;">Datos de tarjeta no válidos.</p>

    <div class="contenedor-centrado">
        <div class="direccion">
            <h1>Datos de envío</h1>
            <div class="centrar">
                <form class="form-direccion">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" placeholder="ingrese un nombre" required>

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" placeholder="ingrese calle y número" required>

                    <label for="cp">Código Postal:</label>
                    <input type="text" name="cp" placeholder="ingrese código postal" required>

                    <label for="pais">País:</label>
                    <input type="text" name="pais" placeholder="ingrese país" required>

                </form>
            </div>
        </div>
        <div class="pago">
            <h1>Datos de la tarjeta</h1>
            <div class="centrar">
                <form class="form-pago" id="payment-form" method="POST">
                    <div class="num-tarjeta">
                        <label for="card-number">Número de Tarjeta:</label>
                        <input type="text" id="card-number" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="datos-tarjeta">
                        <div class="expiracion">
                            <label for="expiry-date">Fecha de Expiración:</label>
                            <input type="text" id="expiry-date" placeholder="MM/AA" required>
                        </div>
                        <div class="cvv">
                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" placeholder="123" required>
                        </div>

                    </div>
                    <div class="botones">
                        <button class="boton" id="generate-card">Cargar Tarjeta Guardada</button>
                        <button class="boton btn-pagar" type="submit" name="pagar">Pagar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="../js/pago.js"></script>
</body>

</html>
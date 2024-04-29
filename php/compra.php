<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}

// Verificar si hay productos en el carrito
if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"]) && !empty($_SESSION["carrito"])) {
    $productos = $_SESSION["carrito"];
    $total = 0;
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

    <link rel="preload" href="../css/ticket.css" as="style">
    <link rel="stylesheet" href="../css/ticket.css">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>

<body>

    <section class="contenedor-registro">
        <form class="contenedor-registro-panel">
            <div class="exito-titulo">
                <div class="exito-cont-img">
                    <img class="exito-img" src="../img/check.webp" alt="icono user">
                </div>
            </div>
            <H1 class="exito-h1">¡Compra realizada con exito!
            </H1>

            <div class="ticket">
                <h2>Ticket de compra</h2>
                <?php foreach ($productos as $producto) : ?>
                    <div class="producto">
                        <span><?php echo $producto['nombre']; ?></span>
                        <div class="producto-precio">
                            <span><?php echo '$' . $producto['precio']; ?></span>
                            <span>Cantidad: <?php echo $producto['cantidad']; ?></span>
                        </div>

                    </div>
                    <?php $total += $producto['precio'] * $producto['cantidad']; ?>
                <?php endforeach; ?>
                <hr>
                <div class="total">
                    <span>Total: <?php echo '$' . $total; ?></span>
                </div>
            </div>

            <?php unset($_SESSION["carrito"]); ?>

            <div class="registro-botones">
                <a class="boton btn-continuar" href="../php/productos.php">Continuar</a>
            </div>
        </form>
    </section>

</body>

<!-- <script src="../js/registrarse.js"></script> -->

</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Tareas</title>

    <!-- Preload -->
    <link rel="preload" href="../css/normalize.css" as="style">
    <link rel="stylesheet" href="../css/normalize.css">

    <link rel="preload" href="../css/registrarse.css" as="style">
    <link rel="stylesheet" href="../css/registrarse.css">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>

<body>

    <section class="contenedor-registro">
        <form class="contenedor-registro-panel" action="../php/registro.php" method="post">
            <div class="registro-icono">
                <div class="icono-cont-img">
                    <img class="icono-img" src="../img/usuario.webp" alt="icono user">
                </div>
            </div>
            <H1 class="titulo-h1">Registrarse</H1>
            <div class="registro-campos">
                <div class="elemento-info div-nombre">
                    <input class="nombre" type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="elemento-info div-edad">
                    <input class="edad" type="number" name="edad" placeholder="Edad" required>
                </div>
                <div class="elemento-info  div-email">
                    <input class="email" type="email" name="email" placeholder="Email" required>
                </div>
                <div class="elemento-info  div-usuario">
                    <input class="usuario" type="text" name="username" placeholder="Usuario" required>
                </div>
                <div class="elemento-info-pass div-password">
                    <input class="password" type="password" name="password" placeholder="Contraseña" required>
                    <span class="ver-password">
                        <img class="password-icono" src="../img/ojo.webp" alt="ojo">
                    </span>
                </div>
                <div class="elemento-info-pass div-confirmar-password">
                    <input class="confirmar-password" type="password" name="confirmar-password" placeholder="Confirmar contraseña" required>
                    <span class="ver-password-c">
                        <img class="password-icono" src="../img/ojo.webp" alt="ojo">
                    </span>
                </div>
            </div>
            <?php
            if (isset($_SESSION["error"])) {
                echo "<p id='registro-error'>{$_SESSION["error"]}</p>";
                unset($_SESSION["error"]);
            }
            ?>
            <div class="registro-botones">
                <button class="boton btn-enviar" type="submit">Enviar</button>
                <a class="boton btn-reset" href="../index.php">Cancelar</a>
            </div>
        </form>
    </section>

</body>

<script src="../js/registrarse.js"></script>

</html>
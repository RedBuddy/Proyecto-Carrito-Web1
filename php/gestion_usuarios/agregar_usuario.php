<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
}

if ($_SESSION['username'] != 'admin') {
    header("Location: ../../productos.php");
}

require '../../includes/config/database.php';
$db = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $query_verificar = "SELECT * FROM usuarios WHERE Usuario = '$usuario' OR Email = '$email'";
    $res_verificar = mysqli_query($db, $query_verificar);
    if (mysqli_num_rows($res_verificar) > 0) {
        $_SESSION["usuario_error"] = "Error! Ya existe una cuenta con este Usuario y/o Email.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Encriptar la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Actualizar los datos en la base de datos
        $query = "INSERT INTO usuarios (Nombre, Edad, Email, Usuario, Contrasena, Verificado) VALUES ('$nombre', $edad, '$email', '$usuario', '$contrasena_hash', '1')";
        $res = mysqli_query($db, $query);

        if ($res) {
            $_SESSION["usuario_actualizado"] = "Usuario agregado correctamente.";
        } else {
            $_SESSION["usuario_error"] = "Error al agregar el usuario.";
        }
    }




    mysqli_close($db);
    header("Location:  gestion_usuarios.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página de Gestión de usuarios</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="../../css/normalize.css" />
    <link rel="stylesheet" href="../../css/editar_usuario.css" />
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
            <a class="link seleccionado" href="gestion_usuarios.php">Gestión de usuarios</a>
            <a class="link" href="ventas_usuarios.php">Ventas por usuario</a>
            <a class="link" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
            <a class="link" href="../informes/ventas.php">Informes</a>
        </div>
    </header>
    <div class="banner">
        <div class="subtitulo">
            <h2>Agregar usuario</h2>
        </div>
        <!-- <div class="gestion-links-cont">
            <div class="gestion-links">
                <a class="link-gestion" href="agregar_usuario.php">Agregar usuario</a>
                <a class="link-gestion" href="baja_usuario.php">Alta/Baja usuario</a>
                <a class="link-gestion" href="modificar_usuario.php">Modificar usuario</a>
            </div>
        </div> -->
    </div>

    <?php if (isset($_SESSION['usuario_error'])) {
        echo "<p id='alerta_roja'>{$_SESSION['usuario_error']}</p>";
        unset($_SESSION['usuario_error']);
    } ?>

    <div class="contenedor">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="100" height="100" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
                <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
            </svg>
        </div>
        <div class="formulario-agregar">
            <form method="post">
                <div class="elemento-info div-nombre">
                    <label for="nombre">Nombre:</label>
                    <input class="nombre" type="text" name="nombre" required>
                </div>
                <div class="elemento-info div-edad">
                    <label for="edad">Edad:</label>
                    <input class="edad" type="number" name="edad" required>
                </div>
                <div class="elemento-info  div-email">
                    <label for="email">Email:</label>
                    <input class="email" type="email" name="email" required>
                </div>
                <div class="elemento-info  div-usuario">
                    <label for="usuario">Usuario:</label>
                    <input class="usuario" type="text" name="usuario" required>
                </div>
                <div class="elemento-info-pass div-password">
                    <label for="password">Contraseña:</label>
                    <input class="password" type="password" name="password" required>
                    <span class="ver-password">
                        <img class="password-icono" src="../../img/ojonegro.webp" alt="ojo">
                    </span>
                </div>

                <div class="botones">
                    <button class="boton btn-enviar" type="submit">Crear</button>
                    <button class="boton btn-reset" onclick="window.location.href='gestion_usuarios.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/configuracion.js"></script>
    <script src="../../js/verificar_usuario.js"></script>
</body>

</html>
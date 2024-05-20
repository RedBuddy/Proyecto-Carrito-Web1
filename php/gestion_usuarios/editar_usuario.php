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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id_usuario = $_GET["id"];

    // Consultar los datos del usuario
    $query = "SELECT Nombre, Edad, Email, Usuario, Contrasena FROM usuarios WHERE ID = '$id_usuario'";
    $res = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($res);

    if ($res->num_rows > 0) {
        $usuario = $res->fetch_assoc();
        $nombre = $row['Nombre'];
        $edad = $row['Edad'];
        $email = $row['Email'];
        $usuario = $row['Usuario'];
        $contrasena_hash = $row['Contrasena'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_GET["id"];
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $new_password = $_POST["password-new"];


    // Actualizar los datos en la base de datos
    $query = "UPDATE usuarios SET Nombre = '$nombre', Edad = '$edad', Email = '$email', Usuario = '$usuario'";
    // Verificar si se ha ingresado una nueva contraseña
    if (!empty($new_password)) {
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $query .= ", Contrasena = '$new_password_hash'";
    }

    $query .= " WHERE ID = '$id_usuario'";
    $res = mysqli_query($db, $query);

    if ($res) {
        $_SESSION["usuario_actualizado"] = "Usuario actualizado correctamente.";
    } else {
        $_SESSION["usuario_error"] = "Error al actualizar el usuario.";
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
<<<<<<< HEAD
    <title>Edición de usuarios</title>
=======
    <title>Página de Gestión de usuarios</title>
>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775
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
<<<<<<< HEAD
            <h2>Editar usuario</h2>
=======
            <h2>Gestión de usuarios</h2>
>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775
        </div>
        <!-- <div class="gestion-links-cont">
            <div class="gestion-links">
                <a class="link-gestion" href="agregar_usuario.php">Agregar usuario</a>
                <a class="link-gestion" href="baja_usuario.php">Alta/Baja usuario</a>
                <a class="link-gestion" href="modificar_usuario.php">Modificar usuario</a>
            </div>
        </div> -->
    </div>

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
            <form action="#" method="post">
<<<<<<< HEAD
                <div class="elemento-info div-nombre">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="nombre" name="nombre" value="<?php echo $nombre; ?>" />
                </div>

                <div class="elemento-info div-edad">
                    <label for="edad">Edad:</label>
                    <input type="number" class="edad" name="edad" value="<?php echo $edad; ?>" />
                </div>

                <div class="elemento-info  div-email">
                    <label for="email">Email:</label>
                    <input type="email" class="email" name="email" value="<?php echo $email; ?>" />
                </div>

                <div class="elemento-info  div-usuario">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                </div>
=======
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />

                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" value="<?php echo $edad; ?>" />

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" />

                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />

>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775

                <label for="password-new">Nueva contraseña (No obligatorio):</label>
                <input class="password-new" type="password" name="password-new" placeholder="Nueva contraseña" />
                <span class="ver-password ver-password-new">
                    <img class="password-icono" src="../../img/ojonegro.webp" alt="ojo" />
                </span>

                <div class="botones">
<<<<<<< HEAD
                    <button class="boton btn-enviar" type="submit">Actualizar</button>
=======
                    <button class="boton" type="submit">Actualizar</button>
>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775
                    <button class="boton" type="reset">Restablecer</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/configuracion.js"></script>
<<<<<<< HEAD
    <script src="../../js/verificar_usuario.js"></script>
=======
    <script src="../../js/verificaciones.js"></script>
>>>>>>> 524161ad20b8c5923eb50499d4de09dace722775
</body>

</html>
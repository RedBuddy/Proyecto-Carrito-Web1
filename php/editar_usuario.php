<?php
require '../includes/config/database.php';
$db = conectarBD();

// Verificar si hay una sesión iniciada
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Consultar los datos del usuario
    $query = "SELECT Nombre, Edad, Email, Usuario, Contrasena FROM usuarios WHERE Usuario = '$username'";
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
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $new_password = $_POST["password-new"];
    $confirm_password = $_POST["password-confirm"];

    // Verificar que la contraseña actual sea correcta
    if (password_verify($password, $contrasena_hash)) {
        // Verificar que la nueva contraseña y la confirmación coincidan
        if ($new_password === $confirm_password) {
            // Actualizar los datos en la base de datos
            $query = "UPDATE usuarios SET Nombre = '$nombre', Edad = '$edad', Email = '$email', Usuario = '$usuario'";
            // Verificar si se ha ingresado una nueva contraseña
            if (!empty($new_password)) {
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $query .= ", Contrasena = '$new_password_hash'";
            }

            $query .= " WHERE Usuario = '$username'";
            $res = mysqli_query($db, $query);

            if ($res) {
                $_SESSION["usuario_actualizado"] = "Usuario actualizado correctamente.";
                $_SESSION['username'] =  $usuario;
            } else {
                $_SESSION["usuario_error"] = "Error al actualizar el usuario.";
            }
        } else {
            $_SESSION["usuario_error"] = "La nueva contraseña y la confirmación no coinciden.";
        }
    } else {
        $_SESSION["usuario_error"] = "La contraseña actual es incorrecta.";
    }

    mysqli_close($db);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
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
    <link rel="stylesheet" href="../css/editar_usuario.css" />

    <!-- <link rel="preload" href="css/inicio.css" as="style">
    <link rel="stylesheet" href="css/inicio.css"> -->

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
            <?php
            if (isset($_SESSION['username'])) {
                if ($_SESSION['username'] == 'admin') {
                    echo "<a class='link' href='gestion_productos/gestion.php'>Gestión de productos</a>";
                }
            }
            ?>
            <a class="link seleccionado" href="editar_usuario.php">Editar Perfil</a>
        </div>
    </header>
    <div class="banner">
        <div class="subtitulo">
            <h2>Editar Perfil</h2>
        </div>
        <form class="cont-cerrar-sesion" action="cerrar_sesion.php" method="POST">
            <button class='cerrar-sesion' type="submit">Cerrar sesión</button>
        </form>

    </div>

    <?php if (isset($_SESSION['usuario_actualizado'])) {
        echo "<p id='alerta_verde'>{$_SESSION['usuario_actualizado']}</p>";
        unset($_SESSION['usuario_actualizado']);
    } ?>

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
            <form action="#" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />

                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" value="<?php echo $edad; ?>" />

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" />

                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />

                <label for="password">Contraseña actual:</label>
                <input class="password" type="password" name="password" placeholder="Contraseña actual" required />
                <span class="ver-password">
                    <img class="password-icono" src="../img/ojonegro.webp" alt="ojo" />
                </span>

                <label for="password-new">Nueva contraseña (No obligatorio):</label>
                <input class="password-new" type="password" name="password-new" placeholder="Nueva contraseña" />
                <span class="ver-password ver-password-new">
                    <img class="password-icono" src="../img/ojonegro.webp" alt="ojo" />
                </span>

                <label for="password-confirm">Confirmar Contraseña:</label>
                <input class="password-confirm" type="password" name="password-confirm" placeholder="Confirmar Contraseña" />
                <span class="ver-password ver-password-confirm">
                    <img class="password-icono" src="../img/ojonegro.webp" alt="ojo" />
                </span>
                <div class="botones">
                    <button class="boton" type="submit">Actualizar</button>
                    <button class="boton" type="reset">Restablecer</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/configuracion.js"></script>
    <script src="../js/productos.js"></script>
    <script src="../js/editar_usuario.js"></script>
</body>

</html>
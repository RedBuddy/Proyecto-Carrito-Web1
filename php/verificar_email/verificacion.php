<?php
session_start();

require '../../includes/config/database.php';
$db = conectarBD();

if (isset($_POST["verificar-otp"])) {
    $otp = $_SESSION['otp'];
    $email = $_SESSION['email'];
    $otp_code = $_POST['otp_code'];

    if ($otp != $otp_code) {
        $_SESSION["error"] = "Error! Código Invalido.";
        mysqli_close($db);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    } else {
        mysqli_query($db, "UPDATE usuarios SET verificado = 1 WHERE Email = '$email'");
        header("Location: ../../index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario Registrado</title>

    <!-- Preload -->
    <link rel="preload" href="../../css/normalize.css" as="style">
    <link rel="stylesheet" href="../../css/normalize.css">

    <link rel="preload" href="../../css/registrarse.css" as="style">
    <link rel="stylesheet" href="../../css/registrarse.css">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>

<body>

    <section class="contenedor-registro">
        <form class="contenedor-registro-panel" method="POST">
            <div class="exito-titulo">
                <div class="exito-cont-img">
                    <img class="exito-img" src="../../img/otp.webp" alt="icono otp">
                </div>
            </div>
            <H1 class="otp-h1">Ingresa el codigo enviado a tu email:</H1>

            <div class="registro-campos">
                <input class="input-otp" type="text" name="otp_code" placeholder="Código" required>
            </div>

            <?php
            if (isset($_SESSION["error"])) {
                echo "<p>{$_SESSION["error"]}</p>";
                unset($_SESSION["error"]);
            }
            ?>

            <div class="registro-botones">
                <button type="submit" class="boton btn-continuar" name="verificar-otp">Continuar</button>
            </div>
        </form>
    </section>

</body>

<!-- <script src="../js/registrarse.js"></script> -->

</html>
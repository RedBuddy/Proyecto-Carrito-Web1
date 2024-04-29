<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["eliminar-usuarios"])) {
        setcookie("usuarios", "", time() - 3600, "/");
        header("Location: registrarse.php");
        exit;
    }
}

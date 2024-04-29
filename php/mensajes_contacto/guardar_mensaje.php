<?php
session_start();

require '../../includes/config/database.php';
$db = conectarBD();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];
    $usuario = $_SESSION['username'];

    $query = "INSERT INTO mensajes (Usuario, Nombre, Correo, Mensaje) VALUES ('$usuario', '$nombre', '$correo', '$mensaje')";

    $res = mysqli_query($db, $query);

    if ($res) {
        $_SESSION["mensaje_enviado"] = "Mensaje enviado correctamente.";
    } else {
        $_SESSION["mensaje_error"] = "Error al enviar el mensaje: " . $stmt_productos->error;
    }
}

mysqli_close($db);
header("Location: ../contacto.php");
exit;

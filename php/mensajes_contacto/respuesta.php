<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../../index.php");
}

if ($_SESSION['username'] != 'admin') {
  header("Location: ../productos.php");
}

require '../../includes/config/database.php';
$db = conectarBD();


if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["enviar_email"])) {
  $_SESSION["email_enviar"] = $_POST['contestar_mensaje'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar_email"])) {

  $email = $_SESSION["email_enviar"];

  $asunto = $_POST["asunto"];
  $mensaje = $_POST["mensaje"];

  require "../../mail/phpmailer/PHPMailerAutoload.php";
  $mail = new PHPMailer;

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tls';

  $mail->Username = 'orlandolmsm@gmail.com';
  $mail->Password = 'jkocwtwiesgrwtjz';

  $mail->setFrom('orlandolmsm@gmail.com', 'Cafe del Bosque - Mensaje de administrador');
  $mail->addAddress($email);

  $mail->isHTML(true);
  $mail->Subject = "$asunto";
  $mail->Body = "<p>Hola querido usuario, </p> <h3>$mensaje<br></h3>";

  mysqli_close($db);
  if (!$mail->send()) {
    $_SESSION["error_mensaje"] = "Error al enviar el correo, Email Invalido";
  } else {
    $_SESSION["mensaje_enviado"] = "Mensaje enviado correctamente a $email";
  }

  header("Location: notificaciones.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responder Mensaje</title>
  <!-- Estilos -->
  <link rel="stylesheet" href="../../css/normalize.css" />
  <link rel="stylesheet" href="../../css/respuesta.css" />
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
      <a class="link" href="gestion.php">Gestión de productos</a>
      <a class="link" href="../gestion_usuarios/ventas_usuarios.php">Ventas por usuario</a>
      <a class="link seleccionado" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
      <a class="link" href="../informes/ventas.php">Informes</a>
    </div>
  </header>
  <div class="banner">
    <div class="subtitulo">
      <h2>Notificaciones</h2>
    </div>
  </div>

  <!-- Formulario de respuesta -->
  <div class="formulario-respuesta">
    <form method="POST">
      <div class="campo">
        <label for="para">Para:</label>
        <input type="email" id="para" name="para" value="<?php echo $_SESSION["email_enviar"]; ?>" readonly />
      </div>
      <div class="campo">
        <label for="asunto">Asunto:</label>
        <input type="text" id="asunto" name="asunto" required />
      </div>
      <div class="campo">
        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="6" required></textarea>
      </div>
      <div class="botones">
        <button type="submit" class="boton-enviar" name="enviar_email">Enviar</button>
        <a type="button" class="boton-cancelar" href="notificaciones.php">Cancelar</a>
      </div>
    </form>
  </div>

  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
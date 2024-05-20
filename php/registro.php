<?php
session_start();

require '../includes/config/database.php';
$db = conectarBD();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $email = $_POST['email'];
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    $query_verificar = "SELECT * FROM usuarios WHERE Usuario = '$usuario' OR Email = '$email'";
    $res_verificar = mysqli_query($db, $query_verificar);
    if (mysqli_num_rows($res_verificar) > 0) {
        $_SESSION["error"] = "Error! Ya existe una cuenta con este Usuario y/o Email.";
    } else {

        // Encriptar la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios (Nombre, Edad, Email, Usuario, Contrasena) VALUES ('$nombre', $edad, '$email', '$usuario', '$contrasena_hash')";

        $res = mysqli_query($db, $query);

        if ($res) {
            $_SESSION["error"] = "Revisa tu bandeja de spam.";

            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            require "../mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            $mail->Username = 'orlandolmsm@gmail.com';
            $mail->Password = 'jkocwtwiesgrwtjz';

            $mail->setFrom('orlandolmsm@gmail.com', 'Cafe del Bosque - Codigo de verificacion');
            $mail->addAddress($_POST["email"]);

            $mail->isHTML(true);
            $mail->Subject = "Tu codigo de verificacion";
            $mail->Body = "<p>Querido usuario, </p> <h3>Tu codigo de verificacion es: $otp <br></h3>";

            mysqli_close($db);
            if (!$mail->send()) {
                $_SESSION["error"] = "Registro Fallido, Email Invalido";
            } else {
                header("Location: verificar_email/verificacion.php");
                exit;
            }

            header("Location: registrarse.php");
            exit;
        }
    }
}

mysqli_close($db);
header("Location: registrarse.php");
exit;

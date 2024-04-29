<?php
session_start();

require '../includes/config/database.php';
$db = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["username"] && $_POST["password"]) {
        $usuario = $_POST['username'];
        $contrasena = $_POST['password'];

        // Obtener la contraseña almacenada en la base de datos para el usuario
        $query = "SELECT Contrasena, Verificado, Email FROM usuarios WHERE Usuario = '$usuario'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $contrasena_hash = $row['Contrasena'];
        $email = $row['Email'];
        $verificado = $row['Verificado'];

        if ($verificado == 1) {
            if (password_verify($contrasena, $contrasena_hash)) {
                $_SESSION['username'] = $usuario;
                mysqli_close($db);
                header("Location: ../php/productos.php");
                exit;
            } else {
                $_SESSION["error"] = "Error! Credenciales incorrectas.";
                mysqli_close($db);
            }
        } else {
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
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Tu codigo de verificacion";
            $mail->Body = "<p>Querido usuario, </p> <h3>Tu codigo de verificacion es: $otp <br></h3>";

            mysqli_close($db);
            if (!$mail->send()) {
                $_SESSION["error"] = "Verificación Fallida, Email Invalido";
            } else {
                header("Location: verificar_email/verificacion.php");
                exit;
            }
        }
    }
}

header("Location: ../index.php");
exit;

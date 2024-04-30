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

// Marcar como leído o no leído
if (isset($_POST['marcar_leido'])) {
  $id_mensaje = $_POST['marcar_leido'];
  $sql = "UPDATE mensajes SET Visto = NOT Visto WHERE ID = $id_mensaje";
  mysqli_query($db, $sql);
}

// Eliminar mensaje
if (isset($_POST['eliminar_mensaje'])) {
  $id_mensaje = $_POST['eliminar_mensaje'];
  $sql = "DELETE FROM mensajes WHERE ID = $id_mensaje";
  mysqli_query($db, $sql);
}


// Consulta a la base de datos
$condicion = "";
if (isset($_POST['mostrar_leidos'])) {
  $condicion = "WHERE Visto = 1";
} elseif (isset($_POST['mostrar_no_leidos'])) {
  $condicion = "WHERE Visto = 0";
}

$query = "SELECT ID, Usuario, Nombre, Correo, Mensaje, Visto FROM mensajes $condicion";
$res = mysqli_query($db, $query);

$mensajes = [];

if ($res->num_rows > 0) {
  // Almacenar los datos en un array
  while ($row = $res->fetch_assoc()) {
    $mensaje = [
      'id' => $row['ID'],
      'usuario' => $row['Usuario'],
      'nombre' => $row['Nombre'],
      'correo' => $row['Correo'],
      'mensaje' => $row['Mensaje'],
      'visto' => $row['Visto'],
    ];
    array_push($mensajes, $mensaje);
  }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página de Gestión de Productos</title>
  <!-- Estilos -->
  <link rel="stylesheet" href="../../css/normalize.css" />
  <link rel="stylesheet" href="../../css/notificaciones.css" />
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
      <a class="link" href="../gestion_usuarios/gestion_usuarios.php">Gestión de usuarios</a>
      <a class="link seleccionado" href="notificaciones.php">Notificaciones</a>
      <a class="link" href="../informes/ventas.php">Informes</a>
    </div>
  </header>
  <div class="banner">
    <div class="subtitulo">
      <h2>Notificaciones</h2>
    </div>
  </div>

  <?php if (isset($_SESSION['mensaje_enviado'])) {
    echo "<p id='alerta_verde'>{$_SESSION['mensaje_enviado']}</p>";
    unset($_SESSION['mensaje_enviado']);
  } ?>

  <?php if (isset($_SESSION['error_mensaje'])) {
    echo "<p id='alerta_roja'>{$_SESSION['error_mensaje']}</p>";
    unset($_SESSION['error_mensaje']);
  } ?>

  <div class="status-mensaje">
    <form method="POST">
      <button class="boton" name="mostrar_leidos">Mostrar Leídos</button>
      <button class="boton" name="mostrar_no_leidos">Mostrar No Leídos</button>
    </form>
  </div>

  <!-- Agregar la tabla para mostrar los mensajes -->
  <div class="tabla-notificaciones">
    <table>
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Mensaje</th>
          <th>Leído</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($mensajes as $mensaje) : ?>
          <tr>
            <td><?php echo ($mensaje['usuario']); ?></td>
            <td><?php echo ($mensaje['nombre']); ?></td>
            <td><?php echo ($mensaje['correo']); ?></td>
            <td><?php echo ($mensaje['mensaje']); ?></td>
            <td>
              <form method="POST">
                <button class="boton-visto" name="marcar_leido" value="<?php echo $mensaje['id']; ?>">
                  <?php echo ($mensaje['visto'] ? 'Marcar no leído' : 'Marcar leído'); ?>
                </button>
              </form>
            </td>
            <td class="botones_contestar">
              <form method="POST">
                <button class="boton-eliminar" name="eliminar_mensaje" value="<?php echo $mensaje['id']; ?>">
                  Eliminar
                </button>
              </form>
              <form method="POST" action="respuesta.php">
                <button class="boton-contestar" name="contestar_mensaje" value="<?php echo $mensaje['correo']; ?>">
                  Contestar
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script src="../js/configuracion.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>
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

// Consulta a la base de datos
$query = "SELECT ID, Nombre, Edad, Email, Usuario, Contrasena, Verificado, Activo FROM usuarios";
$res = mysqli_query($db, $query);

$usuarios = [];

if ($res->num_rows > 0) {
    // Almacenar los datos en un array
    while ($row = $res->fetch_assoc()) {
        $usuario = [
            'id' => $row['ID'],
            'nombre' => $row['Nombre'],
            'edad' => $row['Edad'],
            'email' => $row['Email'],
            'usuario' => $row['Usuario'],
            'contrasena' => $row['Contrasena'],
            'verificado' => $row['Verificado'],
            'activo' => $row['Activo']

        ];
        array_push($usuarios, $usuario);
    }
}

mysqli_close($db);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página de Gestión de Usuarios</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="../../css/normalize.css" />
    <link rel="stylesheet" href="../../css/gestion.css" />
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
            <a class="link" href="gestion_usuarios.php">Gestión de usuarios</a>
            <a class="link seleccionado" href="ventas_usuarios.php">Ventas por usuario</a>
            <a class="link" href="../mensajes_contacto/notificaciones.php">Notificaciones</a>
            <a class="link" href="../informes/ventas.php">Informes</a>
        </div>
    </header>
    <div class="banner">
        <div class="subtitulo">
            <h2>Historial de ventas por usuario</h2>
        </div>
        <!-- <div class="gestion-links-cont">
            <div class="gestion-links">
                <a class="link-gestion" href="baja_usuario.php">Alta/Baja usuario</a>
                <a class="link-gestion" href="modificar_usuario.php">Modificar usuario</a>
            </div>
        </div> -->
    </div>

    <?php if (isset($_SESSION['usuario_actualizado'])) {
        echo "<p id='alerta_verde'>{$_SESSION['usuario_actualizado']}</p>";
        unset($_SESSION['usuario_actualizado']);
    } ?>

    <?php if (isset($_SESSION['usuario_error'])) {
        echo "<p id='alerta_roja'>{$_SESSION['usuario_error']}</p>";
        unset($_SESSION['usuario_error']);
    } ?>

    <!-- Barra de búsqueda -->
    <form class="search-bar">
        <input type="text" id="filtro" placeholder="Buscar el usuario..." />
        <button type="submit">Borrar</button>
    </form>

    <div class="lista-productos" id="lista-productos">
        <?php foreach ($usuarios as $usuario) : ?>
            <div class="product-item" data-nombre="<?php echo strtolower($usuario['usuario']); ?>">
                <div class="product-item-details">
                    <h3><?php echo $usuario['usuario']; ?></h3>
                    <p>Nombre: <?php echo $usuario['nombre']; ?></p>
                    <p>Edad: <?php echo $usuario['edad']; ?></p>
                    <p>Email: <?php echo $usuario['email']; ?></p>
                    <a class="edit-button" href="historial_usuario.php?id=<?php echo $usuario['usuario']; ?>">Ver historial</a> <!-- Enlace de modificar -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        document.getElementById('filtro').addEventListener('input', function() {
            var filtro = document.getElementById('filtro').value.toLowerCase();
            var productos = document.querySelectorAll('.lista-productos .product-item');
            productos.forEach(function(producto) {
                var nombre = producto.dataset.nombre.toLowerCase();
                if (nombre.includes(filtro)) {
                    producto.style.display = 'flex'; // Mostrar elementos que coinciden con el filtro
                } else {
                    producto.style.display = 'none'; // Ocultar elementos que no coinciden con el filtro
                }
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            // Escuchar clics en los botones de desactivar y activar
            document.querySelectorAll('.deactivate-button, .activate-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id_usuario = this.getAttribute('data-id');
                    var nuevo_estado = this.classList.contains('deactivate-button') ? 0 : 1;

                    // Enviar una solicitud AJAX al servidor
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'actualizar_estado_usuario.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Actualizar el estado visualmente en la página
                                if (nuevo_estado === 0) {
                                    button.classList.remove('deactivate-button');
                                    button.classList.add('activate-button');
                                    button.textContent = 'Activar';
                                } else {
                                    button.classList.remove('activate-button');
                                    button.classList.add('deactivate-button');
                                    button.textContent = 'Desactivar';
                                }
                            } else {
                                alert('Error al actualizar el estado del usuario');
                            }
                        }
                    };
                    xhr.send('id_usuario=' + id_usuario + '&nuevo_estado=' + nuevo_estado);
                });
            });
        });
    </script>


    <script src="../../js/configuracion.js"></script>
</body>

</html>
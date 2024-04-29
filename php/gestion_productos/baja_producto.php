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
$query = "SELECT ID, Nombre, Precio, Imagen, Activo FROM productos";
$res = mysqli_query($db, $query);

$productos = [];

if ($res->num_rows > 0) {
    // Almacenar los datos en un array
    while ($row = $res->fetch_assoc()) {
        $producto = [
            'id' => $row['ID'],
            'nombre' => $row['Nombre'],
            'precio' => $row['Precio'],
            'imagen' => $row['Imagen'],
            'activo' => $row['Activo']
        ];
        array_push($productos, $producto);
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
    <link rel="stylesheet" href="../../css/gestion.css" />
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Island+Moments&display=swap" rel="stylesheet" />
</head>

<body>
    <header class="header">
        <div class="header-logo">
            <img src="../../img/cafe.webp" alt="cafe logo" />
            <h1>Café del bosque</h1>
        </div>
        <div class="header-links">
            <a class="link" href="../productos.php">Productos</a>
            <a class="link" href="../configuracion.php">Configuración</a>
            <a class="link" href="../contacto.php">Contacto</a>
            <a class="link seleccionado" href="gestion.php">Gestión de productos</a>
        </div>
    </header>
    <div class="banner">
        <div class="subtitulo">
            <h2>Gestión de productos</h2>
        </div>
        <div class="gestion-links-cont">
            <div class="gestion-links">
                <a class="link-gestion" href="agregar_producto.php">Agregar producto</a>
                <a class="link-gestion" href="baja_producto.php">Alta/Baja producto</a>
                <a class="link-gestion" href="modificar_producto.php">Modificar producto</a>
            </div>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <form class="search-bar">
        <input type="text" id="filtro" placeholder="Buscar producto..." />
        <button type="submit">Borrar</button>
    </form>

    <div class="lista-productos" id="lista-productos">
        <?php foreach ($productos as $producto) : ?>
            <div class="product-item" data-nombre="<?php echo strtolower($producto['nombre']); ?>">
                <img src="../<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" />
                <div class="product-item-details">
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p>Precio: $<?php echo $producto['precio']; ?></p>
                    <?php if ($producto['activo']) : ?>
                        <button class="deactivate-button" data-id="<?php echo $producto['id']; ?>">Desactivar</button>
                    <?php else : ?>
                        <button class="activate-button" data-id="<?php echo $producto['id']; ?>">Activar</button>
                    <?php endif; ?>
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
                    var id_producto = this.getAttribute('data-id');
                    var nuevo_estado = this.classList.contains('deactivate-button') ? 0 : 1;

                    // Enviar una solicitud AJAX al servidor
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'actualizar_estado_producto.php', true);
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
                                alert('Error al actualizar el estado del producto');
                            }
                        }
                    };
                    xhr.send('id_producto=' + id_producto + '&nuevo_estado=' + nuevo_estado);
                });
            });
        });
    </script>


    <script src="../../js/configuracion.js"></script>
</body>

</html>
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

$producto = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id_producto = $_GET["id"];

    // Consultar los datos del producto
    $query = "SELECT p.ID, p.Nombre, p.Descripcion, p.Precio, a.Stock, p.Imagen FROM productos p INNER JOIN almacen a ON p.ID = a.ProductoID WHERE p.ID = $id_producto";
    $res = mysqli_query($db, $query);

    if ($res->num_rows > 0) {
        $producto = $res->fetch_assoc();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST["id_producto"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    // Procesar la imagen si se ha subido una nueva
    if ($_FILES["foto"]["size"] > 0) {
        $imagen_nombre = $_FILES["foto"]["name"];
        $imagen_temporal = $_FILES["foto"]["tmp_name"];
        $imagen_ruta = "../img/productos/{$imagen_nombre}";
        move_uploaded_file($imagen_temporal, "../" . $imagen_ruta);

        // Actualizar la ruta de la imagen en la base de datos
        $query = "UPDATE productos SET Imagen = '$imagen_ruta' WHERE ID = $id_producto";
        $res = mysqli_query($db, $query);
    }

    // Actualizar los datos en la base de datos
    $query = "UPDATE productos SET Nombre = '$nombre', Descripcion = '$descripcion', Precio = $precio WHERE ID = $id_producto";
    $res = mysqli_query($db, $query);

    // Actualizar el stock en la tabla Almacen
    $query_stock = "UPDATE almacen SET Stock = $stock WHERE ProductoID = $id_producto";
    $res_stock = mysqli_query($db, $query_stock);

    if ($res && $res_stock) {
        mysqli_close($db);
        $_SESSION["producto_editado"] = "Producto editado correctamente.";
        header("Location: modificar_producto.php");
        exit;
    } else {
        mysqli_close($db);
        $_SESSION["producto_editado_error"] = "Error al editar correctamente.";
        header("Location: modificar_producto.php");
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
    <div class="formulario">
        <div class="imagen-producto">
            <img class="img-product-select" src="../<?php echo $producto['Imagen']; ?>" alt="Producto Seleccionado" />
        </div>
        <form id="formularioAgregarProducto" class="formulario-agregar editar-fix" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="<?php echo $producto['ID']; ?>">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $producto['Nombre']; ?>" required />
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo $producto['Descripcion']; ?></textarea>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $producto['Precio']; ?>" required />
            </div>
            <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo $producto['Stock']; ?>" required />
            </div>
            <div>
                <label for="foto">Fotografía:</label>
                <input type="file" id="foto" name="foto" accept="image/*" />
            </div>
            <!-- Contenedor para mostrar la imagen seleccionada -->
            <div id="imagenSeleccionada"></div>
            <div>
                <button class="boton-enviar" type="submit">Guardar</button>
                <button type="reset">Restablecer</button>
            </div>
        </form>

    </div>
    <script src="../../js/configuracion.js"></script>
    <script src="../../js/verificaciones.js"></script>
</body>

</html>
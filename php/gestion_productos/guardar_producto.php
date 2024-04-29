<?php
session_start();

require '../../includes/config/database.php';
$db = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $activo = isset($_POST["activo"]) ? 0 : 1;
    $stock = $_POST["stock"];

    // Procesar imagen
    $imagen_nombre = $_FILES["imagen"]["name"];
    $imagen_tmp = $_FILES["imagen"]["tmp_name"];
    $ruta_imagen = "../img/productos/" . $imagen_nombre;
    move_uploaded_file($imagen_tmp, "../" . $ruta_imagen);

    // Insertar en la tabla Productos
    $query_productos = "INSERT INTO productos (Nombre, Descripcion, Precio, Imagen, Activo) VALUES (?, ?, ?, ?, ?)";
    $stmt_productos = $db->prepare($query_productos);
    $stmt_productos->bind_param("ssdsi", $nombre, $descripcion, $precio, $ruta_imagen, $activo);
    $stmt_productos->execute();

    // Obtener el ID del producto insertado
    $producto_id = $stmt_productos->insert_id;

    // Insertar en la tabla Almacen
    $query_almacen = "INSERT INTO almacen (ProductoID, Stock) VALUES (?, ?)";
    $stmt_almacen = $db->prepare($query_almacen);
    $stmt_almacen->bind_param("ii", $producto_id, $stock);
    $stmt_almacen->execute();

    if ($stmt_productos->affected_rows > 0 && $stmt_almacen->affected_rows > 0) {
        $_SESSION["producto_agregado"] = "Producto agregado correctamente.";
        header("Location: agregar_producto.php");
        exit;
    } else {
        $_SESSION["producto_agregado_error"] = "Error al insertar el producto: " . $stmt_productos->error;
        header("Location: agregar_producto.php");
        exit;
    }

    $stmt_productos->close();
    $stmt_almacen->close();
    $db->close();
}

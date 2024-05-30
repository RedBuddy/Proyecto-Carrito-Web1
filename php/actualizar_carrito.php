<?php
session_start();

// Función para verificar la disponibilidad de los productos en la tabla 'almacen' y restar la cantidad comprada
function verificarProductos($productos)
{
    require '../includes/config/database.php';
    $db = conectarBD();

    foreach ($productos as $productoId => $cantidad) {
        // Verificar si el producto está disponible en 'almacen'
        $query = "SELECT Stock FROM almacen WHERE ProductoID = $productoId";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $cantidadAlmacen = $row['Stock'];

        echo "cantidad pedida:" . $cantidad['cantidad'];
        echo "cantidad almacen:" . $cantidadAlmacen;

        // Verificar si hay suficientes productos en 'almacen'
        if ($cantidadAlmacen >= $cantidad['cantidad']) {
            mysqli_close($db);
            return true;
        } else {
            mysqli_close($db);
            return false;
        }
    }
}

function pagarProductos($productos)
{
    require '../includes/config/database.php';
    $db = conectarBD();

    foreach ($productos as $productoId => $cantidad) {
        // Verificar si el producto está disponible en 'almacen'
        $query = "SELECT Stock FROM almacen WHERE ProductoID = $productoId";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $cantidadAlmacen = $row['Stock'];


        // Verificar si hay suficientes productos en 'almacen'
        if ($cantidadAlmacen >= $cantidad['cantidad']) {
            // Restar la cantidad comprada de 'almacen'
            $nuevaCantidad = $cantidadAlmacen - $cantidad['cantidad'];
            $query = "UPDATE almacen SET Stock = $nuevaCantidad WHERE ProductoID = $productoId";
            mysqli_query($db, $query);
        } else {
            mysqli_close($db);
            return false;
        }
    }

    mysqli_close($db);
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $cantidades = $_POST["cantidad"];
    foreach ($cantidades as $productoId => $cantidad) {
        $_SESSION["carrito"][$productoId]["cantidad"] = $cantidad;
    }

    if (!verificarProductos($_SESSION["carrito"])) {
        $_SESSION["error_stock"] = 'Error: No hay stock suficiente para completar la compra, ajusta la cantidad correctamente.';
    }

    header("Location: carrito.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pagar"])) {

    if (pagarProductos($_SESSION["carrito"])) {
        header("Location: pago.php");
        exit;
    } else {
        $_SESSION["error_compra"] = "Error: No hay stock suficiente para completar la compra, ajusta la cantidad correctamente.";
        header("Location: carrito.php");
        exit;
    }
}

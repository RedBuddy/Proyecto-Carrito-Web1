<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $productoId = $_GET["id"];
    if (isset($_SESSION["carrito"][$productoId])) {
        unset($_SESSION["carrito"][$productoId]);
    }
}

header("Location: carrito.php");
exit;

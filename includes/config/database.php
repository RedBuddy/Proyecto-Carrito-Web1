<?php

function conectarBD(): mysqli
{
    $db = mysqli_connect('localhost', 'root', '', 'carrito');

    if (!$db) {
        echo '<script>alert("No se pudo conectar a la BD");</script>';
        exit;
    }

    return $db;
}

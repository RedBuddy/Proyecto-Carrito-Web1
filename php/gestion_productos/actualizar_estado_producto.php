<?php
require '../../includes/config/database.php';
$db = conectarBD();

// Verificar si se ha enviado un ID de producto y un nuevo estado
if (isset($_POST['id_producto']) && isset($_POST['nuevo_estado'])) {
    $id_producto = $_POST['id_producto'];
    $nuevo_estado = $_POST['nuevo_estado'];

    // Actualizar el estado del producto en la base de datos
    $query = "UPDATE productos SET Activo = ? WHERE ID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ii", $nuevo_estado, $id_producto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Devolver una respuesta
    echo json_encode(array('success' => true));
} else {
    // Devolver un error si no se proporcionan los parámetros adecuados
    echo json_encode(array('success' => false, 'message' => 'Parámetros incorrectos'));
}

mysqli_close($db);

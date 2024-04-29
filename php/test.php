<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Página</title>
</head>

<body>
    <?php
    // Obtener el var_dump de la URL y mostrarlo en pantalla
    if (isset($_GET['var_dump'])) {
        $varDumpOutput = urldecode($_GET['var_dump']);
        echo "<pre>" . htmlspecialchars($varDumpOutput) . "</pre>";
    }
    ?>
</body>

</html>
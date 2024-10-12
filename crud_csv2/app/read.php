<?php
include 'functions.php';

$id = $_GET['id'] ?? '';
$registro = leerRegistro($id);

if (!$registro) {
    echo "Registro no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Registro</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Detalles del Registro</h1>
    <p>Nombre: <?php echo $registro['nombre']; ?></p>
    <p>Edad: <?php echo $registro['edad']; ?></p>
    <p>Curso: <?php echo $registro['curso']; ?></p>
    <a href="../index.php">Volver</a>
</body>
</html>
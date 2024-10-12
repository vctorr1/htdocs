<?php
include 'functions.php';

$id = $_GET['id'] ?? '';
$registro = leerRegistro($id);

if (!$registro) {
    echo "Registro no encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registroActualizado = [
        'nombre' => $_POST['nombre'],
        'edad' => $_POST['edad'],
        'curso' => $_POST['curso']
    ];
    actualizarRegistro($id, $registroActualizado);
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Registro</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Actualizar Registro</h1>
    <form method="post">
        <label>Nombre: <input type="text" name="nombre" value="<?php echo $registro['nombre']; ?>" required></label><br>
        <label>Edad: <input type="number" name="edad" value="<?php echo $registro['edad']; ?>" required></label><br>
        <label>Curso: <input type="text" name="curso" value="<?php echo $registro['curso']; ?>" required></label><br>
        <input type="submit" value="Actualizar">
    </form>
    <a href="../index.php">Volver</a>
</body>
</html>
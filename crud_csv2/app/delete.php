<?php
include 'functions.php';

$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    eliminarRegistro($id);
    header('Location: index.php');
    exit;
}

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
    <title>Eliminar Registro</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Eliminar Registro</h1>
    <p>¿Estás seguro de que quieres eliminar este registro?</p>
    <label>Username: <input type="text" name="username" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Seguidores: <input type="number" name="seguidores" required></label><br>
    <label>Siguiendo: <input type="number" name="siguiendo" required></label><br>
    <label>Bio: <textarea name="bio" required></textarea></label><br>
    <form method="post">
        <input type="submit" value="Sí, eliminar">
    </form>
    <a href="../index.php">Cancelar</a>
</body>
</html>
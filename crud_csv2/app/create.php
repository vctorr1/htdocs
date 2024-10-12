<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoRegistro = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'seguidores' => $_POST['seguidores'],
        'siguiendo' => $_POST['siguiendo'],
        'bio' => $_POST['bio']
    ];
    crearRegistro($nuevoRegistro);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Nuevo Usuario</h1>
    <form method="post">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Seguidores: <input type="number" name="seguidores" required></label><br>
        <label>Siguiendo: <input type="number" name="siguiendo" required></label><br>
        <label>Bio: <textarea name="bio" required></textarea></label><br>
        <input type="submit" value="Crear">
    </form>
    <a href="../index.php">Volver</a>
</body>
</html>
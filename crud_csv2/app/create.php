<?php
include 'functions.php';

//usamos el método post para obtener el contenido de los campos del formulario dentro de la tabla y enviar los nuevos valores
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoRegistro = [
        //$_POST  es an associative array of variables passed to the current script via the HTTP POST method.
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'seguidores' => $_POST['seguidores'],
        'siguiendo' => $_POST['siguiendo'],
        'bio' => $_POST['bio']
    ];
    //llamamos al metodo de funciones para crear los registros
    crearRegistro($nuevoRegistro);
    header('Location: index.php');
    exit;
}
//html que compone al página de creación de usuario y enviamos a template 2
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Nuevo Usuario</h1>
    <!--fromulario de método post-->
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
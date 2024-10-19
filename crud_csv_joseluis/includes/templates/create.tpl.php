<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Creacion de nuevo resultado</h1>
    <form action="./create.php" method="post">
        <p><label for="name"><strong><input type="text" name="name"></strong></label></p>
        <p><label for="descripcion"<input type="text" name="descripcion"></p>
        <p><input type="text" name="orden"></p>
        <p><input type="text" name="modulo_id"></p>
        <p><input type="text" name="abreviatura_id"></p>
        <input type="submit" name="boton_enviar" value="Enviar">
    </form>
</body>
</html>
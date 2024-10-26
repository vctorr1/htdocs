<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Resultado de Aprendizaje</title>
</head>
<body>
    <h1>Creación de nuevo resultado de aprendizaje</h1>
    <div><?php echo $mensajesUsuario; ?></div>
    <form action="./create.php" method="post">
        <p><label for="name"><strong>Nombre: </strong></label><input type="text" name="name" id="name"></p>
        <p><label for="descripcion"><strong>Descripción:</strong></label> <input type="text" name="descripcion" id="descripcion"></p>
        <p><label for="orden"><strong>Orden: </strong></label><input type="text" name="orden"  id="orden"></p>
        <p><label for="modulo_id"><strong>Id de módulo: </strong></label><input type="text" name="modulo_id"  ></p>
        <p><label for="abreviatura_id"><strong>Abreviatura (id): </strong></label><input type="text" name="abreviatura_id" id="abreviatura_id"></p>
        <input type="submit" name="boton_enviar" value="Enviar" />
        <a class="action-btn" href="index.php">Volver</a>
    </form>
</body>
</html>
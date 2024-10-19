<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Registro</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Añadir Nuevo Registro</h1>
    <form action="index.php?action=add" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required><br>
        <label for="curso">Curso:</label>
        <input type="text" id="curso" name="curso" required><br>
        <input type="submit" value="Añadir">
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
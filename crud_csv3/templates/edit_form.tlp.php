<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Editar Registro</h1>
    <form action="index.php?action=edit&id=<?php echo $id; ?>" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($record[0]); ?>" required><br>
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($record[1]); ?>" required><br>
        <label for="curso">Curso:</label>
        <input type="text" id="curso" name="curso" value="<?php echo htmlspecialchars($record[2]); ?>" required><br>
        <input type="submit" value="Actualizar">
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
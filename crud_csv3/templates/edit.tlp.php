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
        <input type="text" id="username" name="username" value="<?php echo isset($record) ? htmlspecialchars($record['username']) : ''; ?>" required><br>
        <input type="email" id="email" name="email" value="<?php echo isset($record) ? htmlspecialchars($record['email']) : ''; ?>" required><br>
        <input type="date" id="fecha_registro" name="fecha_registro" value="<?php echo isset($record) ? htmlspecialchars($record['fecha_registro']) : ''; ?>" required><br>
        <input type="number" id="seguidores" name="seguidores" value="<?php echo isset($record) ? htmlspecialchars($record['seguidores']) : '0'; ?>" required><br>
        <input type="number" id="siguiendo" name="siguiendo" value="<?php echo isset($record) ? htmlspecialchars($record['siguiendo']) : '0'; ?>" required><br>
        <textarea id="bio" name="bio" rows="4" cols="50"><?php echo isset($record) ? htmlspecialchars($record['bio']) : ''; ?></textarea><br>

        <input type="submit" value="Actualizar">
    </form>
    <a href="index.php">Volver a la lista</a>
</body>

</html>
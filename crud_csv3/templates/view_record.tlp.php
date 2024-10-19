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
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($record[0]); ?></p>
    <p><strong>Edad:</strong> <?php echo htmlspecialchars($record[1]); ?></p>
    <p><strong>Curso:</strong> <?php echo htmlspecialchars($record[2]); ?></p>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
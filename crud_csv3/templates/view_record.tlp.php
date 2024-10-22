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
    <p><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($record['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($record['email']); ?></p>
    <p><strong>Fecha de registro:</strong> <?php echo htmlspecialchars($record['fecha_registro']); ?></p>
    <p><strong>Seguidores:</strong> <?php echo htmlspecialchars($record['seguidores']); ?></p>
    <p><strong>Siguiendo:</strong> <?php echo htmlspecialchars($record['siguiendo']); ?></p>
    <p><strong>Biografía:</strong> <?php echo htmlspecialchars($record['bio']); ?></p>
    <a href="index.php">Volver</a>
</body>

</html>
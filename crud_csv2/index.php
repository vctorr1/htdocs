<?php
include 'app/functions.php';

$mensaje = '';
//eliminar registros usando post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    eliminarRegistro($_POST['id']);
    $mensaje = "Usuario eliminado exitosamente.";
}

$registros = leerRegistros();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Gestión de Usuarios</h1>
    
    <?php if ($mensaje): ?>
        <p><strong><?php echo $mensaje; ?></strong></p>
    <?php endif; ?>
    <!--em-->
    <a href="templates/template2.php?accion=crear">Crear Nuevo Usuario</a>

    <h2>Lista de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Fecha de Registro</th>
            <th>Seguidores</th>
            <th>Siguiendo</th>
            <th>Bio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?php echo $registro['id']; ?></td>
            <td><?php echo $registro['username']; ?></td>
            <td><?php echo $registro['email']; ?></td>
            <td><?php echo $registro['fecha_registro']; ?></td>
            <td><?php echo $registro['seguidores']; ?></td>
            <td><?php echo $registro['siguiendo']; ?></td>
            <td><?php echo $registro['bio']; ?></td>
            <td>
                <a href="templates/template2.php?accion=editar&id=<?php echo $registro['id']; ?>">Editar</a>
                <form method="post" action="index.php" style="display:inline;">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                    <input type="submit" value="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php
include '../app/functions.php';

$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? '';

$registro = [];
if ($accion == 'editar' && $id) {
    $registro = leerRegistro($id);
    if (!$registro) {
        die("Usuario no encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoRegistro = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'seguidores' => $_POST['seguidores'],
        'siguiendo' => $_POST['siguiendo'],
        'bio' => $_POST['bio']
    ];
    
    if ($accion == 'crear') {
        crearRegistro($nuevoRegistro);
    } elseif ($accion == 'editar') {
        $nuevoRegistro['id'] = $id;
        $nuevoRegistro['fecha_registro'] = $registro['fecha_registro'];
        actualizarRegistro($id, $nuevoRegistro);
    }
    
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $accion == 'editar' ? 'Editar Usuario' : 'Crear Nuevo Usuario'; ?></title>
        <!-- Minified version -->
        <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1><?php echo $accion == 'editar' ? 'Editar Usuario' : 'Crear Nuevo Usuario'; ?></h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required value="<?php echo $accion == 'editar' ? htmlspecialchars($registro['username']) : ''; ?>">
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?php echo $accion == 'editar' ? htmlspecialchars($registro['email']) : ''; ?>">
        
        <label for="seguidores">Seguidores:</label>
        <input type="number" id="seguidores" name="seguidores" required value="<?php echo $accion == 'editar' ? htmlspecialchars($registro['seguidores']) : ''; ?>">
        
        <label for="siguiendo">Siguiendo:</label>
        <input type="number" id="siguiendo" name="siguiendo" required value="<?php echo $accion == 'editar' ? htmlspecialchars($registro['siguiendo']) : ''; ?>">
        
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" required><?php echo $accion == 'editar' ? htmlspecialchars($registro['bio']) : ''; ?></textarea>
        
        <input type="submit" value="<?php echo $accion == 'editar' ? 'Actualizar Usuario' : 'Crear Usuario'; ?>">
    </form>
    <p><a href="../index.php">Volver a la lista de usuarios</a></p>
</body>
</html>
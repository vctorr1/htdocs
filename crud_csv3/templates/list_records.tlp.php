<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Registros</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Lista de Registros</h1>
    <a href="index.php?action=add">Añadir nuevo registro</a>
    <form action="index.php" method="post">
        <table>
            <tr>
                <!--Encabezados-->
                <th>Seleccionar</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha Registro</th>
                <th>Seguidores</th>
                <th>Siguiendo</th>
                <th>Bio</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($data as $index => $row): ?>
            <tr>
                <td>
                    <input type="checkbox" name="selected[]" value="<?php echo $index; ?>">
                </td>
                <!--omitimos el primer índice del array porque es el id-->
                <td><?php echo htmlspecialchars($row[1]); ?></td>
                <td><?php echo htmlspecialchars($row[2]); ?></td>
                <td><?php echo htmlspecialchars($row[3]); ?></td>
                <td><?php echo htmlspecialchars($row[4]); ?></td>
                <td><?php echo htmlspecialchars($row[5]); ?></td>
                <td><?php echo htmlspecialchars($row[6]); ?></td>
                <td>
                    <a href="index.php?action=view&id=<?php echo $index; ?>">Ver</a>
                    <a href="index.php?action=edit&id=<?php echo $index; ?>">Editar</a>
                    <a href="index.php?action=delete&id=<?php echo $index; ?>" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <select name="bulk_action">
            <option value="">Seleccionar acción</option>
            <option value="delete">Eliminar</option>
            <option value="edit">Editar</option>
        </select>
        <input type="submit" value="Aplicar a seleccionados">
    </form>
</body>
</html>
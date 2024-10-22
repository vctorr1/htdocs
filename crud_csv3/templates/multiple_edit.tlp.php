<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edición Masiva de Registros</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Edición Masiva de Registros</h1>
    <form action="index.php?action=multi_edit" method="post">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha Registro</th>
                <th>Seguidores</th>
                <th>siguiendo</th>
                <th>Bio</th>
            </tr>
            <?php foreach ($selectedRecords as $id => $record): ?>
            <tr>
                <td>
                    <input type="text" name="records[<?php echo $id; ?>][username]" value="<?php echo htmlspecialchars($record[1]); ?>" required>
                </td>
                <td>
                    <input type="text" name="records[<?php echo $id; ?>][email]" value="<?php echo htmlspecialchars($record[2]); ?>" required>
                </td>
                <td>
                    <input type="text" name="records[<?php echo $id; ?>][fecha_registro]" value="<?php echo htmlspecialchars($record[3]); ?>" required>
                </td>
                <td>
                    <input type="number" name="records[<?php echo $id; ?>][seguidores]" value="<?php echo htmlspecialchars($record[4]); ?>" required>
                </td>
                <td>
                    <input type="number" name="records[<?php echo $id; ?>][siguiendo]" value="<?php echo htmlspecialchars($record[5]); ?>" required>
                </td>
                <td>
                    <input type="text" name="records[<?php echo $id; ?>][bio]" value="<?php echo htmlspecialchars($record[6]); ?>" required>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" value="Actualizar Registros">
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
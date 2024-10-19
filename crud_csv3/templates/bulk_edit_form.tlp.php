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
    <form action="index.php?action=bulk_edit" method="post">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Curso</th>
            </tr>
            <?php foreach ($selectedRecords as $id => $record): ?>
            <tr>
                <td>
                    <input type="text" name="records[<?php echo $id; ?>][nombre]" value="<?php echo htmlspecialchars($record[0]); ?>" required>
                </td>
                <td>
                    <input type="number" name="records[<?php echo $id; ?>][edad]" value="<?php echo htmlspecialchars($record[1]); ?>" required>
                </td>
                <td>
                    <input type="text" name="records[<?php echo $id; ?>][curso]" value="<?php echo htmlspecialchars($record[2]); ?>" required>
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
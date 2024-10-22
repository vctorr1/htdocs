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
            <tr><!--Preguntar a joseluis mañana por si cambio al modelo de presentación de view record-->
                <!--Encabezados-->
                <th>Seleccionar</th>
                <?php foreach (array_keys($data[0]) as $header): ?>
                    <th><?php echo htmlspecialchars($header); ?></th>
                <?php endforeach; ?>
                <th>Acciones</th>
            </tr>
            <?php foreach ($data as $index => $record): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="selected[]" value="<?php echo $index; ?>">
                    </td>
                    <!--omitimos el primer índice del array porque es el id-->
                    </td>
                    <?php foreach ($record as $field): ?>
                        <td><?php echo htmlspecialchars($field); ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="index.php?action=view&id=<?php echo $index; ?>">Ver</a>
                        <a href="index.php?action=edit&id=<?php echo $index; ?>">Editar</a>
                        <a href="index.php?action=delete&id=<?php echo $index; ?>">Eliminar</a>
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
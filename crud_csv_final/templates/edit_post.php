<!DOCTYPE html>
<html>

<head>
    <title>Editar Post</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
    <h1>Editar Post</h1>
    <form method="POST" action="index.php?action=edit_post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
        <?php foreach ($post as $key => $value): ?>
            <?php if ($key !== 'id'): ?>
                <div class="form-group">
                    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
                    <input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>"
                        value="<?php echo htmlspecialchars($value); ?>">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Guardar cambios</button>
        <a href="index.php?action=list_posts">Cancelar</a>
    </form>
</body>

</html>
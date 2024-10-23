<!DOCTYPE html>
<html>

<head>
    <title>Lista de Usuarios</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
    <h1>Lista de Usuarios</h1>
    <nav>
        <a href="index.php?action=list_posts">Posts</a> |
        <a href="index.php?action=list_users">Usuarios</a>
    </nav>
    <?php
    $users = getUsers();
    if (!empty($users)) {
        $headers = array_keys($users[0]);
        echo getMarkup($users, $headers, false);
    } else {
        echo '<p>No hay usuarios disponibles.</p>';
    }
    ?>
</body>

</html>
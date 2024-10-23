<!DOCTYPE html>
<html>

<head>
    <title>Lista de Posts</title>
    <!-- Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
    <h1>Lista de Posts</h1>
    <nav>
        <a href="index.php?action=list_posts">Posts</a> |
        <a href="index.php?action=list_users">Usuarios</a>
    </nav>
    <?php
    $posts = getPosts();
    if (!empty($posts)) {
        $headers = array_keys($posts[0]);
        echo getMarkup($posts, $headers);
    } else {
        echo '<p>No hay posts disponibles.</p>';
    }
    ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas</title>
    <!-- Un-Minified version -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">

</head>
<body>
    <h1>Usuarios y posts</h1>
    <?php
    echo $finalTable;
    //echo $deleteButton;
    //echo $restoreButton;
    ?>
    <!-- formularios con método POST-->
    <form action="/ej_tablas/app/deletecsv.php" method="post">
        <label for="campo_texto"></label>
        <input name="campo_texto" id="campo_texto" type="text">
        <input type="submit" value="Borrar">
    </form>
    <form action="/ej_tablas/app/restorecsv.php" method="post">
        <label for="campo_texto1"></label>
        <input name="campo_texto1" id="campo_texto1" type="text">
        <input type="submit" value="Restaurar">
    </form>
    <form action="/ej_tablas/app/randomuser.php" method="post">
        <label for="campo_texto2"></label>
        <input name="campo_texto2" id="campo_texto2" type="text">
        <input type="submit" value="Usuario Aleatorio">
    </form>
</body>
</html>

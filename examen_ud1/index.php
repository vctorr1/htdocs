<?php
include('vars.php');
require_once('funciones.php');

//$bodyOutput = listGamesTable($videojuegos);

//$bodyOutput = generateGamesHTML($videojuegos);
$bodyOutput .= generateSelectionForm();
$bodyOutput .= generateTable($videojuegos);

$action = $_GET['accion'];


$videojuegosFiltrados = filtrarTabla($videojuegos);
$bodyOutput2 = generateTable($videojuegosFiltrados);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    echo $bodyOutput;
    echo $bodyOutput2;
    ?>
</body>

</html>
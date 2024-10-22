<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('./includes/funciones.inc');
include_once('./includes/env.inc');

setErrorHandlers();


//zona de variables globales
$bodyOutput = '';



include('./templates/index.tpl.php');

$registros = getRegistrosFromCSV('./resources/csv/users-table1.csv');

$bodyOutput = 
?>
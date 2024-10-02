<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once('app/vars.php');
include_once('app/functions.php');

$arrayResultados = getArrayFromCSV('resources/csv/resultados.csv');

$bodyOutput = getTableMarkup($arrayResultados);

include('templates/template1.php');

?>
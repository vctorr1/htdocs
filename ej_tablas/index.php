<?php
//Configuración de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Importamos los archivo necesariosw
include_once('app/vars.php');
include_once('app/functions.php');
include_once('app/deletecsv.php');
include_once('app/restorecsv.php');

//solucion joseluis
//$arrayResultados = getArrayFromCSV1("model/users-table.csv");
//dump($arrayResultados);

//Almacenamos los datos de cada csv en una variable para su manejo poesteriormente
$usersData = getDataFromCSV('model/users-table.csv');
$postsData = getDataFromCSV('model/posts-table.csv');

//Prueba deleteCSV de functions.php
//deleteCSV1('model/users-table1.csv'); 
//regenerateCSV('model/users-table1.csv', $usersData);

//Prueba scripts delete y restore
//deleteCSV('model/users-table1.csv');
//restoreCSV('model/users-table1.csv', $usersData);


//generamos el lenguaje de marcas a partir del los datos almacenados
$finalTable = getMarkup($usersData, $postsData);



$deleteButton = '<a href="app/deletecsv.php">Borrar</a>';
$restoreButton = '<a href="app/restorecsv.php">Restaurar</a>';

//Incluimos la plantilla para mostrar los resultados
include('templates/template1.php');
?>
<?php
//Configuración de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Importamos los archivo necesarios
include_once("scripts/read.php");
//include_once se usa para librerias, no para scripts

//solucion joseluis
//$arrayResultados = getArrayFromCSV1("model/users-table.csv");
//dump($arrayResultados);
$userData = getDataFromCSV('model/users-table1.csv');
$finalTable = getMarkup($userData);

//Almacenamos los datos de cada csv en una variable para su manejo poesteriormente


//generamos el lenguaje de marcas a partir del los datos almacenados
//$finalTable = getMarkup($usersData, $postsData);

//Incluimos la plantilla para mostrar los resultados
include('templates/template1.php');

?>
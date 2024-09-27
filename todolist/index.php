<?php
//Estas tres líneas hacen que se muestren todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//se importan las variables y funciones empleadas, así como el template para mostrar la información en el html
include_once('app/vars.php');
include_once('app/functions.php');

//Almacenamos en la variable lista el array que nos devuelve la función getListFromDB
$list = getListFromDB();
//Asignamos a bodyOutput el array ya en formato html
$bodyOutput = getListMarkup($list);

//TO DO: Poner aquí lo que falte.
//incluimos el template al final para pasarle los datos de la variable bodyOutput
include('templates/template1.php');


?>

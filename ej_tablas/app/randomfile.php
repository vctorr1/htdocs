<?php

include_once('functions.php');

//función para cargar un registro aleatorio
function getRandomField($postsData){
    //Usamos la función array_rand para obtener un elemento aleatorio del array de datos del csv
    $fieldArray = array_rand($postsData,1);
    return $fieldArray;
}
//Se ejecuta el método al acceder al script
$usersData = getDataFromCSV("../model/users-table.csv");
$postsData = getDataFromCSV("../model/posts-table.csv");
$randomFieldKey = getRandomField($postsData);

echo $finalField = getMarkup($usersData, $postsData[$randomFieldKey]);

//HAY QUE TERMINAR RANDOMFILE



//Redirigimos de vuelta a la página principal
//header("Location: ../index.php");
//exit();

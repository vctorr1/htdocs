<?php

include_once('functions.php');

function restoreCSV($filename, array $data_array){
    //Abrimos flujo de entrada para escritura
    $output_file = fopen($filename, "w");
    //imprimimos los headers, array_keys devuelve los index y reset hace que devuelva los valores que contienen
    fputcsv($output_file, array_keys(reset($data_array)));
    //Escribimos en el csv los los campos del array
    foreach($data_array as $cell) {
        fputcsv($output_file, $cell);
    }
    fclose($output_file);

};
//Se ejecuta el método al acceder al script
restoreCSV("../model/users-table1.csv", getDataFromCSV("../model/users-table.csv"));

//Redirigimos de vuelta a la página principal
header("Location: ../index.php");
exit();


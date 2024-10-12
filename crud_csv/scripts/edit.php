<?php
function editCSV($filename, array $newValues){
    //Abrimos flujo de entrada para escritura
    $output_file = fopen($filename, "w");
    //imprimimos los headers, array_keys devuelve los index y reset hace que devuelva los valores que contienen
    fputcsv($output_file, array_keys(reset($newValues)));
    //Escribimos en el csv los los campos del array
    foreach($newValues as $cell) {
        fputcsv($output_file, $cell);
    }
    //Cerramos el flujo de datos
    fclose($output_file);

};
//Se ejecuta el método al acceder al script
editCSV('../model/users-table.csv1', $newValues);

//Redirigimos de vuelta a la página principal
header("Location: ../index.php");
exit();
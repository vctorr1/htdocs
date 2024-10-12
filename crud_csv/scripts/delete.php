<?php

//función para borrar los registros seleccionados del csv
/*function deleteCSV($filename, $registros){
    //Primero borramos el archivo
    unlink($filename);
    //Luego lo volvemos a crear vacío
    $output_file = fopen($filename, "w");
    //Escribimos los registros proporcionados en el archivo de salida
    fputcsv($output_file, $registros);
    //Cerramos el flujo
    fclose($output_file);

}*/

//Prueba versión buena
function deleteRowCSV($filename, $rowId){
    $openTable = fopen($filename, "r");
    //Tabla temporal para cambiar luego
    $tempTable = fopen('../model/temp_table.csv', "w");
    //$row = fgetcsv($filename, 1000, ",");
    //fputcsv($tempTable, $rowId);
    //
    while (($row = fgetcsv($filename, 1000)) !== FALSE){
        if(reset($row) == $rowId){ // this is if you need the first column in a row
            continue;
        }
        fputcsv($tempTable,$row);
    }
    //Cerramos los flujos
    fclose($openTable);
    fclose($tempTable);
    //reemplazamos la tabla original por la temporal con rename
    rename($tempTable, $openTable);

}

//Se ejecuta el método al acceder al script
deleteRowCSV('../model/users-table1.csv', 4);

//Redirigimos de vuelta a la página principal
header("Location: ../index.php");
exit();






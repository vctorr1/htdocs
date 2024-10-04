<?php

//función para borrar todos los registros del csv
function deleteCSV($filename){
    //Primero borramos el archivo
    unlink($filename);
    //Luego lo volvemos a crear vacío
    $output_file = fopen($filename, "w");
    //Cerramos el flujo
    fclose($output_file);

}
//Se ejecuta el método al acceder al script
deleteCSV('../model/users-table1.csv');



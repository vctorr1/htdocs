<?php

//función para borrar los registros seleccionados del csv
function deleteCSV($filename, $registros){
    //Primero borramos el archivo
    unlink($filename);
    //Luego lo volvemos a crear vacío
    $output_file = fopen($filename, "w");
    //Cerramos el flujo
    fclose($output_file);

}
//Se ejecuta el método al acceder al script
deleteCSV('../model/users-table1.csv');

//Redirigimos de vuelta a la página principal
header("Location: ../index.php");
exit();






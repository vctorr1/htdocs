<?php
//Leemos los datos de un archivo CSV y los devolvemos como un array asociativo.
function getDataFromCSV($filename) {
    $data = [];
    if (($csv = fopen($filename, "r")) !== FALSE) {
        //leemos la primera fila como encabezados
        $headers = fgetcsv($csv, 1000, ",");
        //leemos el resto de las filas
        while (($row = fgetcsv($csv, 1000, ",")) !== FALSE) {
            //combinamos los encabezados con valores para crear un array asociativo
            $data[] = array_combine($headers, $row);
        }
        //Cerramos el flujo
        fclose($csv);
    }
    return $data;
}
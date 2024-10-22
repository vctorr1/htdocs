<?php

//función para leer los datos del csv
function readCSV($file) {
    $csvData = [];
    if (($handle = fopen($file, "r")) !== FALSE) {
        //encabezados en la primera línea
        $header = fgetcsv($handle, 1000, ",");
        
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            //array asociativo uniendo los encabezados y las celdas
            $fileArray = array_combine($header, $row);
            $csvData[] = $fileArray;
        }
        fclose($handle);
    }
    return $csvData; //devolvemos el array de datos
}

//función para escribir los datos en el csv
function writeCSV($file, $csvData) {
    $handle = fopen($file, 'w'); //abrimos con permiso de lectura
    foreach ($csvData as $row) {
        fputcsv($handle, $row); //escribimos cada fila
    }
    fclose($handle); //Cerramos el archivo
}

//función para encontrar un registro en el array REVISAR PORQUE HE CAMBIADO A ARRAY ASOCIATIVO
function findRecord($csvData, $id) {
    return isset($csvData[$id]) ? $csvData[$id] : null; //Devuelve el registro si existe o null si no
}

//htmlspecialchars + quitar los espacios
function validateInput($input) {
    return htmlspecialchars(trim($input));
}

//función para eliminar un registro del array del csv (el & antes de la variable es para pasarla por referencia)
function deleteRecord(&$csvData, $id) {
    if (isset($csvData[$id])) {
        unset($csvData[$id]);
        return true;
    }
    return false;
}

//función para actualizar una celda en el array
function updateRecord(&$csvData, $id, $newRecord) {
    if (isset($csvData[$id])) { 
        $csvData[$id] = $newRecord; 
        return true; 
    }
    return false; 
}
?>
<?php

//leemos los datos del csv y los pasamos a un array
function readCSV($filename) {
    $data = [];
    //saltamos los encabezados
    if (($handle = fopen($filename, "r")) !== FALSE) {
        //saltamos los encabezados
        fgetcsv($handle, 1000, ",");
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $row;
        }
        
        fclose($handle);
    }
    return $data;
}

//
function writeCSV($filename, $data) {
    $fp = fopen($filename, 'w');
    foreach ($data as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
}

function findRecord($data, $id) {
    return isset($data[$id]) ? $data[$id] : null;
}

function validateInput($input) {
    return htmlspecialchars(trim($input));
}

function deleteRecord(&$data, $id) {
    if (isset($data[$id])) {
        unset($data[$id]);
        return true;
    }
    return false;
}

function updateRecord(&$data, $id, $newRecord) {
    if (isset($data[$id])) {
        $data[$id] = $newRecord;
        return true;
    }
    return false;
}
?>
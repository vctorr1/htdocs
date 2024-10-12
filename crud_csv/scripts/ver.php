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

function getMarkup($userData) {
    $html = "<table>";
    
    //Añadimos los encabezados de la tabla
    $html .= "<tr>
        <th>Seleccionar</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Fecha Registro</th>
        <th>Seguidores</th>
        <th>Siguiendo</th>
        <th>Bio</th>
        <th></th>
        </tr>";

    //iteramos sobre cada usuario
    //FUNCIÓN IMPORTANTE ARRAY_WALK(), QUE APLICA UNA FUNCIÓN A CADA ELEMENTO DE UN ARRAY
    foreach ($userData as $user) {
        $html .= "<tr>";
        $html .= '
                    <td><input type="checkbox" id="check" name="check" /></td>
                    <td>' .($user['username']) . "</td>
                    <td>" .($user['email']) . "</td>
                    <td>" .($user['fecha_registro']) . "</td>
                    <td>" .($user['seguidores']) ."</td>
                    <td>" .($user['siguiendo']) . "</td>
                    <td>" .($user['bio']) . "</td>
                    <td><a href=../scripts/ver.php>Ver</a></td>";
        
        
    }
    //Cerramos la tabla
    $html .= "</table>";
    return $html;
}
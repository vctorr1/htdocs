<?php
/**
 *Lee datos de un archivo CSV y los devuelve como un array asociativo.
 */
function getDataFromCSV($filename) {
    $data = [];
    if (($csv = fopen($filename, "r")) !== FALSE) {
        //Lee la primera fila como encabezados
        $headers = fgetcsv($csv, 1000, ",");
        //leer el resto de las filas
        while (($row = fgetcsv($csv, 1000, ",")) !== FALSE) {
            //Combina los encabezados con valores para crear un array asociativo
            $data[] = array_combine($headers, $row);
        }
        //Cerramos el flujo
        fclose($csv);
    }
    return $data;
}

//Ejemplo de Jose Luis
/*function getArrayFromCSV1($csvUrl){
    //Devuelve un array asociativo con la información contenida en la url que se le pasa como parámetro
    dump($csvUrl);
    dump("+++++++++++++++++++++++++++++");
    $filas = explode("\n",file_get_contents($csvUrl));
    dump($filas);
    dump("+++++++++++++++++++++++++++++");
    array_shift($filas);
    dump("filas despues");
    dump("+++++++++++++++++++++++++++++");
    dump($nombreCols);
    dump("nombre columnas");

    array_walk($filas, 'divide_columnas', $nombreCols);
    dump("+++++++++++++++++++++++++++++");
    
    dump($filas);
    



}   //el ampersand se usa para que los cambios realziados dentro de la variable fila persistan por fuera
function divide_columnas(&$arrayItem, $key, $nombreCols){
    dump($arrayItem);
    dump($key);
    dump("$nombreCols")
    $arrayItem = array_combine($nombreCols, explode(",", $arrayItem));
    dump("+++++++++++++++++++++++++++++");
    
}*/

/**
 *Genera el html para una tabla que combina datos de usuarios y posts.
 */
function getMarkup($usersData, $postsData) {
    $html = "<table>";
    
    //Añadir encabezados de la tabla
    $html .= "<tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Fecha Registro</th>
        <th>Seguidores</th>
        <th>Siguiendo</th>
        <th>Bio</th>
        <th>Post ID</th>
        <th>Imagen</th>
        <th>Descripción</th>
        <th>Fecha Publicación</th>
        <th>Likes</th>
        <th>Comentarios</th>
        <th>Categoría</th>
        </tr>";

    //iteramos sobre cada usuario
    //FUNCIÓN IMPORTANTE ARRAY_WALK(), QUE APLICA UNA FUNCIÓN A CADA ELEMENTO DE UN ARRAY
    foreach ($usersData as $user) {
        //Filtramos posts para el usuario actual usando array_filter
        $userPosts = array_filter($postsData, function($post) use ($user) {
            return $post['user_id'] == $user['id'];
        });

        
        //Si el usuario tiene posts, mostramos una fila por cada post
        $firstPost = true;
        foreach ($userPosts as $post) {
                $html .= "<tr>";
                if ($firstPost) {
                    //para el primer post, mostrar los datos del usuario
                    $html .= "
                        <td>" .($user['id']) . "</td>
                        <td>" .($user['username']) . "</td>
                        <td>" .($user['email']) . "</td>
                        <td>" .($user['fecha_registro']) . "</td>
                        <td>" .($user['seguidores']) ."</td>
                        <td>" .($user['siguiendo']) . "</td>
                        <td>" .($user['bio']) . "</td>";
                    $firstPost = false;
                } else {
                    //Para los posts siguientes, dejar en blanco las columnas de usuario
                    $html .= "<td colspan=7></td>";
                }
                //mostrar los datos del post
                $html .= "
                    <td>" . ($post['id']) . "</td>
                    <td><img src='" . ($post['imagen_url']) . "' alt='imagen''></td>
                    <td>" . ($post['descripcion']) . "</td>
                    <td>" . ($post['fecha_publicacion']) . "</td>
                    <td>" . ($post['likes']) . "</td>
                    <td>" . ($post['comentarios']) . "</td>
                    <td>" . ($post['categoria']) . "</td>
                </tr>";
            
        }
    }
    //Cerramos la tabla
    $html .= "</table>";
    return $html;
}

//función para borrar todos los registros del csv ARREGLAR PARA QUE BORRE TODO EL ARCHIVO
function deleteCSV1($filename){
    $arrayCSV = file($filename);
    //Leemos las cabeceras
    $headers =  str_getcsv(array_shift($arrayCSV));

    //creamos el array asociativo para asignar los valores, siendo el primero la clave y el segundo el valor "" vacío en este caso
    $empty_rows = array_fill_keys($headers, "");
    //abrimos el archivo para escribir en él
    $output_file = fopen($filename, "w");
    //EScribimos en el csv los headers y los campos vacíos
    fputcsv($output_file, $headers);
    foreach($arrayCSV as $row) {
        fputcsv($output_file, $empty_rows);
    }
    //Cerramos el flujo
    fclose($output_file);

}


//Función para regenerar los registros del csv ARREGLAR PARA QUE SE CREE OTRA VEZ CON LOS DATOS
function regenerateCSV($filename, array $data) {
    //Abrimos el flujo de entrada con permiso de escritura
    $output_file = fopen($filename, 'w');
    //Introducimos en el archivo los registro de nuevo
    fputcsv($output_file, array_keys(reset($data)));
    array_walk($data, function($row) use ($output_file) {
        fputcsv($output_file, $row);
    });
    //Cerramos el flujo
    fclose($output_file);
}




function dump($var){
    echo '<pre>'.print_r($var, true).'</pre>';
}
?>
<?php
/**
 * Lee datos de un archivo CSV y los devuelve como un array asociativo.
 */
function getDataFromCSV($filename) {
    $data = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        // Leer la primera fila como encabezados
        $headers = fgetcsv($handle, 1000, ",");
        // Leer el resto de las filas
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Combinar encabezados con valores para crear un array asociativo
            $data[] = array_combine($headers, $row);
        }
        fclose($handle);
    }
    return $data;
}

/**
 * Genera el markup HTML para una tabla que combina datos de usuarios y posts.
 */
function generateJoinedTableMarkup($usersData, $postsData) {
    $markup = "<table border='1'>";
    
    // Añadir encabezados de la tabla
    $markup .= "<tr>
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

    // Iterar sobre cada usuario
    foreach ($usersData as $user) {
        // Filtrar posts para el usuario actual
        $userPosts = array_filter($postsData, function($post) use ($user) {
            return $post['user_id'] == $user['id'];
        });

        if (empty($userPosts)) {
            // Si el usuario no tiene posts, mostrar una fila con datos del usuario y "Sin posts"
            $markup .= "<tr>
                <td>" . htmlspecialchars($user['id']) . "</td>
                <td>" . htmlspecialchars($user['username']) . "</td>
                <td>" . htmlspecialchars($user['email']) . "</td>
                <td>" . htmlspecialchars($user['fecha_registro']) . "</td>
                <td>" . htmlspecialchars($user['seguidores']) . "</td>
                <td>" . htmlspecialchars($user['siguiendo']) . "</td>
                <td>" . htmlspecialchars($user['bio']) . "</td>
                <td colspan='7'>Sin posts</td>
            </tr>";
        } else {
            // Si el usuario tiene posts, mostrar una fila por cada post
            $firstPost = true;
            foreach ($userPosts as $post) {
                $markup .= "<tr>";
                if ($firstPost) {
                    // Para el primer post, mostrar los datos del usuario
                    $markup .= "
                        <td>" . htmlspecialchars($user['id']) . "</td>
                        <td>" . htmlspecialchars($user['username']) . "</td>
                        <td>" . htmlspecialchars($user['email']) . "</td>
                        <td>" . htmlspecialchars($user['fecha_registro']) . "</td>
                        <td>" . htmlspecialchars($user['seguidores']) . "</td>
                        <td>" . htmlspecialchars($user['siguiendo']) . "</td>
                        <td>" . htmlspecialchars($user['bio']) . "</td>";
                    $firstPost = false;
                } else {
                    // Para los posts subsiguientes, dejar en blanco las columnas de usuario
                    $markup .= "<td colspan='7'></td>";
                }
                // Mostrar los datos del post
                $markup .= "
                    <td>" . htmlspecialchars($post['id']) . "</td>
                    <td><img src='" . htmlspecialchars($post['imagen_url']) . "' alt='imagen' style='max-width:100px;'></td>
                    <td>" . htmlspecialchars($post['descripcion']) . "</td>
                    <td>" . htmlspecialchars($post['fecha_publicacion']) . "</td>
                    <td>" . htmlspecialchars($post['likes']) . "</td>
                    <td>" . htmlspecialchars($post['comentarios']) . "</td>
                    <td>" . htmlspecialchars($post['categoria']) . "</td>
                </tr>";
            }
        }
    }

    $markup .= "</table>";
    return $markup;
}
?>
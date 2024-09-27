<?php

// Definir las rutas a las carpetas
define('MODEL_PATH', __DIR__ . '/model/');

// Función para leer un archivo CSV y convertirlo en un array asociativo
function leerCSV($archivo) {
    $ruta_completa = MODEL_PATH . $archivo;
    $datos = array();
    
    if (!file_exists($ruta_completa)) {
        throw new Exception("El archivo $archivo no existe en la carpeta 'model'.");
    }
    
    if (($handle = fopen($ruta_completa, "r")) !== FALSE) {
        $encabezados = fgetcsv($handle);
        while (($fila = fgetcsv($handle)) !== FALSE) {
            $datos[] = array_combine($encabezados, $fila);
        }
        fclose($handle);
    } else {
        throw new Exception("No se pudo abrir el archivo $archivo.");
    }
    
    return $datos;
}

// Función para generar el contenido HTML
function generarContenidoHTML($usuarios, $posts) {
    $postsPorUsuario = array();
    foreach ($posts as $post) {
        $postsPorUsuario[$post['user_id']][] = $post;
    }

    $html = "<h1>Usuarios y Sus Posts</h1>";
    $html .= "<ul>";

    foreach ($usuarios as $usuario) {
        $html .= "<li>";
        $html .= "<strong>{$usuario['username']}</strong> ({$usuario['email']})";
        $html .= "<ul>";
        $html .= "<li>Seguidores: {$usuario['seguidores']}</li>";
        $html .= "<li>Siguiendo: {$usuario['siguiendo']}</li>";
        $html .= "<li>Bio: {$usuario['bio']}</li>";
        
        if (isset($postsPorUsuario[$usuario['id']])) {
            $html .= "<li>Posts:";
            $html .= "<ul>";
            foreach ($postsPorUsuario[$usuario['id']] as $post) {
                $html .= "<li>";
                $html .= "Imagen: <a href='{$post['imagen_url']}' target='_blank'>{$post['imagen_url']}</a><br>";
                $html .= "Descripción: {$post['descripcion']}<br>";
                $html .= "Fecha: {$post['fecha_publicacion']}, Likes: {$post['likes']}, Comentarios: {$post['comentarios']}<br>";
                $html .= "Categoría: {$post['categoria']}";
                $html .= "</li>";
            }
            $html .= "</ul>";
            $html .= "</li>";
        } else {
            $html .= "<li>No hay posts para este usuario.</li>";
        }
        
        $html .= "</ul>";
        $html .= "</li>";
    }

    $html .= "</ul>";

    return $html;
}

// Código principal
try {
    $usuarios = leerCSV('users-table.csv');
    $posts = leerCSV('posts-table.csv');
    $bodyOutput = generarContenidoHTML($usuarios, $posts);
    include('templates/template1.php');
    

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}



?>
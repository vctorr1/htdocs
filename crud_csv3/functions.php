<?php

//función para leer los datos del csv
function readCSV($file) {
    $csvData = [
        //array asociativo con dos claves
        'headers' => [], //array para almacenar los encabezados
        'data' => []    //array para almacenar los datos
    ];
    
    if (($handle = fopen($file, "r")) !== FALSE) {
        //guardamos los encabezados
        $csvData['headers'] = fgetcsv($handle, 1000, ",");
        $index = 0;
        
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($csvData['headers']) === count($row)) {
                $fileArray = array_combine($csvData['headers'], $row);
                $csvData['data'][$index] = $fileArray;
                $index++;
            }
        }
        fclose($handle);
    }
    return $csvData;
}

//función para escribir los datos en el csv
function writeCSV($file, $csvData) {
    if ($handle = fopen($file, 'w')) {
        // Primero escribimos los encabezados
        if (!empty($csvData['headers'])) {
            fputcsv($handle, $csvData['headers']);
        }
        
        // Luego escribimos los datos
        if (!empty($csvData['data'])) {
            foreach ($csvData['data'] as $row) {
                fputcsv($handle, $row);
            }
        }
        
        fclose($handle);
        return true;
    }
    return false;
}

//función para encontrar un registro en el array
function findRecord($csvData, $id) {
    return isset($csvData['data'][$id]) ? $csvData['data'][$id] : null;
}

//htmlspecialchars + quitar los espacios
function validateInput($input) {
    return htmlspecialchars(trim($input));
}

//función para eliminar un registro del array del csv
function deleteRecord(&$csvData, $id) {
    $id = (int)$id;
    if (isset($csvData['data'][$id])) {
        unset($csvData['data'][$id]);
        // Reindexamos el array para mantener índices consecutivos
        $csvData['data'] = array_values($csvData['data']);
        return true;
    }
    return false;
}
function createPostsCSV() {
    $file = './csv/posts-table.csv';
    if (!file_exists($file)) {
        $headers = ['id','user_id', 'imagen_url', 'descripcion', 'fecha_publicacion', 'likes', 'comentarios', 'categorias'];
        $initialData = [
            'headers' => $headers,
            'data' => []
        ];
        writeCSV($file, $initialData);
    }
}

// Función para generar el siguiente ID
function getNextId($csvData) {
    if (empty($csvData['data'])) {
        return 1;
    }
    
    // Encontrar el ID más alto actual
    $maxId = 0;
    foreach ($csvData['data'] as $record) {
        if (isset($record['id']) && $record['id'] > $maxId) {
            $maxId = (int)$record['id'];
        }
    }
    
    return $maxId + 1;
}

// Función para obtener posts de un usuario específico
function getUserPosts($userId) {
    $file = './csv/posts-table.csv';
    $postsData = readCSV($file);
    $userPosts = [];
    
    foreach ($postsData['data'] as $post) {
        if ($post['user_id'] == $userId) {
            $userPosts[] = $post;
        }
    }
    
    return $userPosts;
}

//función para actualizar una celda en el array
function updateRecord(&$csvData, $id, $newRecord) {
    if (isset($csvData['data'][$id])) {
        $csvData['data'][$id] = $newRecord;
        return true;
    }
    return false;
}

//función para generar el html
function generateTableHTML($csvData) {
    if (empty($csvData['data'])) {
        return '<p>No hay registros disponibles.</p>';
    }

    $html = '<form action="index.php" method="post">';
    $html .= '<table>';
    $html .= '<thead><tr>';
    $html .= '<th></th>'; // Para checkboxes
    
    foreach ($csvData['headers'] as $header) {
        $html .= '<th>' . htmlspecialchars($header) . '</th>';
    }
    $html .= '<th>Posts</th>'; // Nueva columna para posts
    $html .= '<th>Acciones</th></tr></thead>';

    $html .= '<tbody>';
    foreach ($csvData['data'] as $index => $record) {
        $html .= '<tr>';
        $html .= '<td><input type="checkbox" name="selected[]" value="' . $index . '"></td>';
        
        foreach ($csvData['headers'] as $header) {
            $html .= '<td>' . htmlspecialchars($record[$header]) . '</td>';
        }
        
        // Añadir celda de posts
        $html .= '<td>';
        $userPosts = getUserPosts($index);
        if (!empty($userPosts)) {
            $html .= '<table class="posts-table">';
            $html .= '<thead><tr><th>Imagen</th><th>Descripción</th><th>Fecha</th><th>Likes</th><th>Comentarios</th><th>Categoría</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($userPosts as $post) {
                $html .= '<tr>';
                $html .= '<td><img src="' . htmlspecialchars($post['imagen_url']) . '"></td>';
                $html .= '<td>' . htmlspecialchars($post['descripcion']) . '</td>';
                $html .= '<td>' . htmlspecialchars($post['fecha_publicacion']) . '</td>';
                $html .= '<td>' . htmlspecialchars($post['likes']) . '</td>';
                $html .= '<td>' . htmlspecialchars($post['comentarios']) . '</td>';
                $html .= '<td>' . htmlspecialchars($post['categoria']) . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';
        } else {
            $html .= '<p>No hay posts</p>';
        }
        $html .= '</td>';
        
        // Celda de acciones
        $html .= '<td>';
        $html .= '<a href="index.php?action=view&id=' . $index . '">Ver</a> ';
        $html .= '<a href="index.php?action=edit&id=' . $index . '">Editar</a> ';
        $html .= '<a href="index.php?action=delete&id=' . $index . '">Eliminar</a>';
        $html .= '<a href="index.php?action=add_post&user_id=' . $index . '">Añadir Post</a>';
        $html .= '</td></tr>';
    }
    $html .= '</tbody></table>';
    
    // Acciones en masa
    $html .= '<select name="bulk_action">';
    $html .= '<option value="">Seleccionar acción</option>';
    $html .= '<option value="delete">Eliminar</option>';
    $html .= '<option value="edit">Editar</option>';
    $html .= '</select>';
    $html .= '<button type="submit">Aplicar a seleccionados</button>';
    $html .= '</form>';
    
    return $html;
}


function generateViewHTML($record) {
    $html = '<h1>Detalles del Registro</h1>';
    $html .= '<p><strong>Nombre de usuario:</strong> ' . htmlspecialchars($record['username']) . '</p>';
    $html .= '<p><strong>Email:</strong> ' . htmlspecialchars($record['email']) . '</p>';
    $html .= '<p><strong>Fecha de registro:</strong> ' . htmlspecialchars($record['fecha_registro']) . '</p>';
    $html .= '<p><strong>Seguidores:</strong> ' . htmlspecialchars($record['seguidores']) . '</p>';
    $html .= '<p><strong>Siguiendo:</strong> ' . htmlspecialchars($record['siguiendo']) . '</p>';
    $html .= '<p><strong>Biografía:</strong> ' . htmlspecialchars($record['bio']) . '</p>';
    $html .= '<a href="index.php">Volver</a>';
    
    return $html;
}

function generateEditHTML($record, $id) {
    $html = '<h1>Editar Registro</h1>';
    $html .= '<form action="index.php?action=edit&id=' . $id . '" method="post">';
    $html .= '<input type="text" id="username" name="username" value="' . 
             (isset($record) ? htmlspecialchars($record['username']) : '') . '" required><br>';
    $html .= '<input type="email" id="email" name="email" value="' . 
             (isset($record) ? htmlspecialchars($record['email']) : '') . '" required><br>';
    $html .= '<input type="date" id="fecha_registro" name="fecha_registro" value="' . 
             (isset($record) ? htmlspecialchars($record['fecha_registro']) : '') . '" required><br>';
    $html .= '<input type="number" id="seguidores" name="seguidores" value="' . 
             (isset($record) ? htmlspecialchars($record['seguidores']) : '0') . '" required><br>';
    $html .= '<input type="number" id="siguiendo" name="siguiendo" value="' . 
             (isset($record) ? htmlspecialchars($record['siguiendo']) : '0') . '" required><br>';
    $html .= '<textarea id="bio" name="bio" rows="4" cols="50">' . 
             (isset($record) ? htmlspecialchars($record['bio']) : '') . '</textarea><br>';
    $html .= '<input type="submit" value="Actualizar">';
    $html .= '</form>';
    $html .= '<a href="index.php">Volver a la lista</a>';
    
    return $html;
}
function generateCreateHTML($headers) {
    $html = '<h2>Crear Nuevo Usuario</h2>';
    $html .= '<form method="POST"';
    
    foreach ($headers as $header) {
        // Saltamos el campo ID ya que se genera automáticamente
        if ($header !== 'id') {
            $html .= '<label for="' . htmlspecialchars($header) . '">' . 
                    ucfirst(htmlspecialchars($header)) . ':</label>';
            
            // Personalizar el campo según el tipo
            switch ($header) {
                case 'bio':
                    $html .= '<textarea name="' . htmlspecialchars($header) . '" id="' . 
                            htmlspecialchars($header) . '" rows="4"></textarea>';
                    break;
                    
                case 'fecha_registro':
                    $html .= '<input type="date" name="' . htmlspecialchars($header) . 
                            '" id="' . htmlspecialchars($header) . '" value="' . 
                            date('Y-m-d') . '">';
                    break;
                    
                case 'seguidores':
                case 'siguiendo':
                    $html .= '<input type="number" name="' . htmlspecialchars($header) . 
                            '" id="' . htmlspecialchars($header) . '" value="0">';
                    break;
                    
                case 'email':
                    $html .= '<input type="email" name="' . htmlspecialchars($header) . 
                            '" id="' . htmlspecialchars($header) . '">';
                    break;
                    
                default:
                    $html .= '<input type="text" name="' . htmlspecialchars($header) . 
                            '" id="' . htmlspecialchars($header) . '">';
            }
            
        }
    }
    
    $html .= '<button type="submit">Guardar</button>';
    $html .= '<a href="index.php">Cancelar</a>';
    $html .= '</form>';
    
    return $html;
}


function generateMultiEditHTML($records, $ids) {
    if (empty($records)) {
        return '<p>No se encontraron registros para editar.</p>';
    }

    $html = '<h2>Edición Múltiple</h2>';
    $html .= '<form action="index.php?action=multi_edit_save" method="post">';
    
    foreach ($records as $id => $record) {
        $html .= '<h3>Registro #' . ($id + 1) . '</h3>';
        
        foreach ($record as $field => $value) {
            $html .= '<label for="' . $field . '_' . $id . '">' . htmlspecialchars($field) . ':</label>';
            
            // Input específico según el tipo de campo
            switch ($field) {
                case 'fecha_registro':
                    $html .= '<input type="date" id="' . $field . '_' . $id . '" ';
                    $html .= 'name="records[' . $id . '][' . $field . ']" ';
                    $html .= 'value="' . htmlspecialchars($value) . '" required>';
                    break;
                    
                case 'seguidores':
                case 'siguiendo':
                    $html .= '<input type="number" id="' . $field . '_' . $id . '" ';
                    $html .= 'name="records[' . $id . '][' . $field . ']" ';
                    $html .= 'value="' . htmlspecialchars($value) . '" required>';
                    break;
                    
                case 'bio':
                    $html .= '<textarea id="' . $field . '_' . $id . '" ';
                    $html .= 'name="records[' . $id . '][' . $field . ']">';
                    $html .= htmlspecialchars($value) . '</textarea>';
                    break;
                    
                default:
                    $html .= '<input type="text" id="' . $field . '_' . $id . '" ';
                    $html .= 'name="records[' . $id . '][' . $field . ']" ';
                    $html .= 'value="' . htmlspecialchars($value) . '" required>';
            }
            
        }
        $html .= '<input type="hidden" name="ids[]" value="' . $id . '">';
    }
    
    $html .= '<button type="submit">Guardar Cambios</button>';
    $html .= '<a href="index.php">Cancelar</a>';
    $html .= '</form>';
    
    return $html;
}

function generateAddPostHTML($userId) {
    $html = '<h2>Añadir Nuevo Post</h2>';
    $html .= '<form action="index.php?action=add_post&user_id=' . $userId . '" method="post">';
    $html .= '<label for="title">Título:</label>';
    $html .= '<input type="text" id="title" name="title" required>';
    
    $html .= '<label for="content">Contenido:</label>';
    $html .= '<textarea id="content" name="content" rows="4" required></textarea>';
    
    $html .= '<button type="submit">Guardar Post</button>';
    $html .= '<a href="index.php">Cancelar</a>';
    $html .= '</form>';
    
    return $html;
}
?>
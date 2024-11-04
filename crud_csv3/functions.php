<?php

//función para leer los datos del csv
function readCSV($file)
{
    $csvData = [
        //dos arrays dentro
        'headers' => [], //array para almacenar los encabezados
        'data' => []    //array para almacenar los datos (almacena los id, que almacenan arrays asociativos con los encabezados y registros)
    ];

    if (($handle = fopen($file, "r")) !== FALSE) {
        //guardamos los encabezados
        $csvData['headers'] = fgetcsv($handle, 1000, ",");
        //contador de id actual
        $index = 0;

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $fileArray = array_combine($csvData['headers'], $row);
            $csvData['data'][$index] = $fileArray;
            $index++;
            /*Ej; username,email,fecha_registro
                vcitor,victor@email.com,2024-01-01
                holaa,holaa@email.com,2024-01-02

                [
                    'headers' => ['username', 'email', 'fecha_registro'],
                    'data' => [
                            0 => [
                                'username' => 'victor',
                                'email' => 'victor@email.com',
                                'fecha_registro' => '2024-01-01'
                            ],
                            1 => [
                                'username' => 'holaa',
                                'email' => 'holaa@email.com',
                                'fecha_registro' => '2024-01-02'
                            ]
                        ]
                ]
                */
        }
        fclose($handle);
    }
    return $csvData;
}

//función para escribir los datos en el csv
function writeCSV($file, $csvData)
{
    if ($handle = fopen($file, 'w')) {
        //primero escribimos los encabezados
        if (!empty($csvData['headers'])) {
            fputcsv($handle, $csvData['headers']);
        }

        //luego escribimos los datos
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
function findRecord($csvData, $id)
{
    //si se encuentra el registro lo devuelve, si no nos devuelve null
    return isset($csvData['data'][$id]) ? $csvData['data'][$id] : null;
}

//funcion para preparar los inputs
function validateInput($input)
{
    return htmlspecialchars(trim($input));
}

//función para eliminar un registro del array del csv
//le pasamos csvData por referencia para que trabaje sobre el array original
function deleteRecord(&$csvData, $id)
{
    $id = (int)$id;
    if (isset($csvData['data'][$id])) {
        unset($csvData['data'][$id]);
        //reindexamos el array para mantener los ids consecutivos
        $csvData['data'] = array_values($csvData['data']);
        return true;
    }
    return false;
}
//funcion para calcular el nuevo id
function getNextId($csvData)
{
    if (empty($csvData['data'])) {
        return 1;
    }

    //cogemos el id más alto y lo devolvemos +1
    $maxId = 0;
    foreach ($csvData['data'] as $record) {
        if (isset($record['id']) && $record['id'] > $maxId) {
            $maxId = (int)$record['id'];
        }
    }

    return $maxId + 1;
}

//función para obtener posts de un usuario específico
function getUserPosts($userId)
{
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
function updateRecord(&$csvData, $id, $newRecord)
{
    if (isset($csvData['data'][$id])) {
        $csvData['data'][$id] = $newRecord;
        return true;
    }
    return false;
}

//función para generar el html
function generateTableHTML($csvData)
{
    if (empty($csvData['data'])) {
        return '<p>No hay registros disponibles.</p>';
    }

    $html = '<form action="index.php" method="post">';
    $html .= '<table>';
    $html .= '<thead><tr>';
    $html .= '<th></th>'; //la de los checkboxes

    foreach ($csvData['headers'] as $header) {
        $html .= '<th>' . htmlspecialchars($header) . '</th>';
    }
    $html .= '<th>Posts</th>'; //para meter dentro la tabla de los posts
    $html .= '<th>Acciones</th></tr></thead>';

    $html .= '<tbody>';
    foreach ($csvData['data'] as $index => $record) {
        $html .= '<tr>';
        $html .= '<td><input type="checkbox" name="selected[]" value="' . $index . '"></td>';

        foreach ($csvData['headers'] as $header) {
            $html .= '<td>' . htmlspecialchars($record[$header]) . '</td>';
        }

        //tabla de posts
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

        //acciones individuales
        $html .= '<td>';
        $html .= '<a href="index.php?action=view&id=' . $index . '">Ver</a> ';
        $html .= '<a href="index.php?action=edit&id=' . $index . '">Editar</a> ';
        $html .= '<a href="index.php?action=delete&id=' . $index . '">Eliminar</a>';
        $html .= '</td></tr>';
    }
    $html .= '</tbody></table>';

    //acciones múltiples
    $html .= '<select name="bulk_action">';
    $html .= '<option value="">Seleccionar acción</option>';
    $html .= '<option value="delete">Eliminar</option>';
    $html .= '<option value="edit">Editar</option>';
    $html .= '</select>';
    $html .= '<button type="submit">Aplicar a seleccionados</button>';
    $html .= '</form>';

    return $html;
}

//markup de la vista detallada
function generateViewHTML($record)
{
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

function generateEditHTML($record, $id)
{
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
function generateCreateHTML($headers)
{
    $html = '<h2>Crear Nuevo Usuario</h2>';
    $html .= '<form method="POST"';

    foreach ($headers as $header) {
        //nos saltamos el id porque se genera solo
        if ($header !== 'id') {
            $html .= '<label for="' . htmlspecialchars($header) . '">' . htmlspecialchars($header) . ':</label>';

            //probando con un switch para cada columna a ver que tal
            switch ($header) {
                case 'bio':
                    $html .= '<textarea name="' . htmlspecialchars($header) . '" id="' . htmlspecialchars($header) . '" rows="4"></textarea>';
                    break;

                case 'fecha_registro':
                    $html .= '<input type="date" name="' . htmlspecialchars($header) . '" id="' . htmlspecialchars($header) . '" value="' . date('Y-m-d') . '">';
                    break;

                case 'seguidores':
                case 'siguiendo':
                    $html .= '<input type="number" name="' . htmlspecialchars($header) . '" id="' . htmlspecialchars($header) . '" value="0">';
                    break;

                case 'email':
                    $html .= '<input type="email" name="' . htmlspecialchars($header) . '" id="' . htmlspecialchars($header) . '">';
                    break;

                default:
                    $html .= '<input type="text" name="' . htmlspecialchars($header) . '" id="' . htmlspecialchars($header) . '">';
            }
        }
    }

    $html .= '<button type="submit">Guardar</button>';
    $html .= '<a href="index.php">Cancelar</a>';
    $html .= '</form>';

    return $html;
}


function generateMultiEditHTML($records, $ids)
{
    if (empty($records)) {
        return '<p>No se encontraron registros para editar.</p>';
    }

    $html = '<h2>Edición Múltiple</h2>';
    $html .= '<form action="index.php?action=multi_edit_save" method="post">';

    foreach ($records as $id => $record) {
        $html .= '<h3>Registro #' . ($id + 1) . '</h3>';

        foreach ($record as $field => $value) {
            $html .= '<label for="' . $field . '_' . $id . '">' . htmlspecialchars($field) . ':</label>';

            //probando con un switch para cada columna a ver que tal
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
        //input type hidden para que no se muestre pero lo podamos usar
        $html .= '<input type="hidden" name="ids[]" value="' . $id . '">';
    }

    $html .= '<button type="submit">Guardar Cambios</button>';
    $html .= '<a href="index.php">Cancelar</a>';
    $html .= '</form>';

    return $html;
}

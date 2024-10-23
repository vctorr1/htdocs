<?php
function readCSV($filename) {
    $rows = array();
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            $row = array();
            for ($i = 0; $i < count($headers); $i++) {
                $row[$headers[$i]] = $data[$i];
            }
            $rows[] = $row;
        }
        fclose($handle);
    }
    return $rows;
}

function writeCSV($filename, $data, $headers) {
    if (($handle = fopen($filename, "w")) !== FALSE) {
        fputcsv($handle, $headers);
        foreach ($data as $row) {
            fputcsv($handle, array_values($row));
        }
        fclose($handle);
    }
}

function getMarkup($data, $displayHeaders) {
    $html = '<form method="POST" action="index.php?action=bulk_action">';
    
    $html .= '<div class="controls">';
    $html .= '<select name="operation" required>';
    $html .= '<option value="">Seleccionar operación</option>';
    $html .= '<option value="edit">Editar</option>';
    $html .= '<option value="delete">Eliminar</option>';
    $html .= '</select>';
    $html .= '<button type="submit">Aplicar a seleccionados</button>';
    $html .= '</div>';

    $html .= '<table class="table">';
    
    // Headers
    $html .= '<thead><tr>';
    $html .= '<th><label><input type="checkbox" name="toggle_all" value="1" form="select_none"> Seleccionar</label></th>';
    foreach ($displayHeaders as $header => $label) {
        $html .= '<th>' . htmlspecialchars($label) . '</th>';
    }
    $html .= '</tr></thead>';
    
    // Data rows
    $html .= '<tbody>';
    foreach ($data as $row) {
        $html .= '<tr>';
        $html .= '<td><label><input type="checkbox" name="selected[]" value="' . 
                 $row['id'] . '_' . ($row['type'] ?? 'post') . '"></label></td>';
        foreach ($displayHeaders as $header => $label) {
            $value = $row[$header] ?? '';
            if ($header === 'imagen_url' && !empty($value)) {
                $html .= '<td><img src="' . htmlspecialchars($value) . '" width="50" height="50" alt="Imagen del post"></td>';
            } else {
                $html .= '<td>' . htmlspecialchars($value) . '</td>';
            }
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    // Formulario oculto para deseleccionar todo
    $html .= '<form id="select_none" method="POST" action="index.php" style="display:none;"></form>';
    
    $html .= '</form>';
    
    return $html;
}

function generateEditForm($selectedIds) {
    $records = getRecordsByIds($selectedIds);
    if (empty($records)) {
        return '<p>No se encontraron registros para editar.</p>';
    }

    $html = '<form method="POST" action="index.php?action=edit">';
    
    foreach ($records as $index => $record) {
        $html .= '<div class="edit-record">';
        $html .= '<h3>Registro #' . ($index + 1) . '</h3>';
        foreach ($record as $key => $value) {
            if ($key !== 'id' && $key !== 'type') {
                $html .= '<div class="form-group">';
                $html .= '<label for="' . $key . '_' . $record['id'] . '">' . ucfirst($key) . '</label>';
                if ($key === 'descripcion') {
                    $html .= '<textarea name="records[' . $record['id'] . '][' . $key . ']" id="' . $key . '_' . $record['id'] . '">' . 
                            htmlspecialchars($value) . '</textarea>';
                } else {
                    $html .= '<input type="text" name="records[' . $record['id'] . '][' . $key . ']" id="' . $key . '_' . $record['id'] . '" value="' . 
                            htmlspecialchars($value) . '">';
                }
                $html .= '</div>';
            } else {
                $html .= '<input type="hidden" name="records[' . $record['id'] . '][' . $key . ']" value="' . htmlspecialchars($value) . '">';
            }
        }
        $html .= '</div>';
    }
    
    $html .= '<div class="form-actions">';
    $html .= '<button type="submit">Guardar cambios</button>';
    $html .= '<a href="index.php" class="button">Cancelar</a>';
    $html .= '</div>';
    $html .= '</form>';
    
    return $html;
}
?>
?>
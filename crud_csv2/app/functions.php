<?php
define('CSV_FILE', __DIR__ . '/../model/users-table1.csv');

function leerRegistros() {
    $registros = [];
    if (($handle = fopen(CSV_FILE, "r")) !== FALSE) {
        // Saltar la primera línea (encabezados)
        fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $registros[] = [
                'id' => $data[0],
                'username' => $data[1],
                'email' => $data[2],
                'fecha_registro' => $data[3],
                'seguidores' => $data[4],
                'siguiendo' => $data[5],
                'bio' => $data[6]
            ];
        }
        fclose($handle);
    }
    return $registros;
}

function leerRegistro($id) {
    $registros = leerRegistros();
    foreach ($registros as $registro) {
        if ($registro['id'] == $id) {
            return $registro;
        }
    }
    return null;
}

function crearRegistro($registro) {
    $handle = fopen(CSV_FILE, "a");
    $nuevoId = obtenerNuevoId();
    fputcsv($handle, [
        $nuevoId,
        $registro['username'],
        $registro['email'],
        date('Y-m-d'), // fecha actual para fecha_registro
        $registro['seguidores'],
        $registro['siguiendo'],
        $registro['bio']
    ]);
    fclose($handle);
    return $nuevoId;
}

function actualizarRegistro($id, $registroActualizado) {
    $registros = leerRegistros();
    $registrosActualizados = [];
    foreach ($registros as $registro) {
        if ($registro['id'] == $id) {
            $registrosActualizados[] = $registroActualizado;
        } else {
            $registrosActualizados[] = $registro;
        }
    }
    escribirRegistros($registrosActualizados);
}

function eliminarRegistro($id) {
    $registros = leerRegistros();
    $registrosActualizados = array_filter($registros, function($registro) use ($id) {
        return $registro['id'] != $id;
    });
    escribirRegistros($registrosActualizados);
}

function escribirRegistros($registros) {
    $handle = fopen(CSV_FILE, "w");
    // Escribir encabezados
    fputcsv($handle, ['id', 'username', 'email', 'fecha_registro', 'seguidores', 'siguiendo', 'bio']);
    foreach ($registros as $registro) {
        fputcsv($handle, [
            $registro['id'],
            $registro['username'],
            $registro['email'],
            $registro['fecha_registro'],
            $registro['seguidores'],
            $registro['siguiendo'],
            $registro['bio']
        ]);
    }
    fclose($handle);
}

function obtenerNuevoId() {
    $registros = leerRegistros();
    $maxId = 0;
    foreach ($registros as $registro) {
        if (intval($registro['id']) > $maxId) {
            $maxId = intval($registro['id']);
        }
    }
    return $maxId + 1;
}
?>
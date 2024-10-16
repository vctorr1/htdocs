<?php
define('CSV_FILE', __DIR__ . '/../model/users-table1.csv');

//función para leer los registros del csv usando fgetcvs
function leerRegistros() {
    $registros = [];
    if (($handle = fopen(CSV_FILE, "r")) !== FALSE) {
        //saltamos los encabezdos
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
        //cerramsoe l flujo
        fclose($handle);
    }//devolvemos los registros
    return $registros;
}
//funcion para leer registros
function leerRegistro($id) {
    $registros = leerRegistros();
    foreach ($registros as $registro) {
        if ($registro['id'] == $id) {
            return $registro;
        }
    }
    return null;
}
//método para crear nuevos registros
function crearRegistro($registro) {
    $handle = fopen(CSV_FILE, "a");
    $nuevoId = obtenerNuevoId();
    fputcsv($handle, [
        $nuevoId,
        $registro['username'],
        $registro['email'],
        date('Y-m-d'), //fecha actual para la fecha de registro usando la calse Date
        $registro['seguidores'],
        $registro['siguiendo'],
        $registro['bio']
    ]);
    fclose($handle);
    return $nuevoId;
}
//funcion para editar los registros
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
    //en lugar de devolver registros llamamos al metodo escribirRegistros e insertamos el nuevo array
    escribirRegistros($registrosActualizados);
}

//eliminamos los registros en funcion al id proporcionado
function eliminarRegistro($id) {
    $registros = leerRegistros();
    $registrosActualizados = array_filter($registros, function($registro) use ($id) {
        return $registro['id'] != $id;
    });
    escribirRegistros($registrosActualizados);
}

//función para escribir los registros
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
//funcion para obtener los nuevos ids
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
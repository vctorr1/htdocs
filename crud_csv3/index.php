<?php
//Incluimos el archivo de funciones
require_once 'functions.php';

//usamos el get para determinar la accion a realizar (obteniendo el valor dep parametro action de la url)
$action = $_GET['action'] ?? 'list';
$file = './csv//users-table1.csv';
$data = readCSV($file);

//switch principal para manejar diferentes acciones que recibimos por post
switch ($action) {
    case 'add':
        //adición de nuevos registros (usamos post para procesar todos los formularios)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRecord = [
                'username' => validateInput($_POST['username']),
                'email' => validateInput($_POST['email']),
                'fecha_registro' => validateInput($_POST['fecha_registro']),
                'seguidores' => validateInput($_POST['seguidores']),
                'siguiendo' => validateInput($_POST['siguiendo']),
                'bio' => validateInput($_POST['bio'])
            ];
            $data[] = $newRecord;
            writeCSV($file, $data);
            header('Location: index.php');
            exit;
        }
        include 'templates/create.tlp.php';   
        break;

    case 'edit':
        //edición de registros individuales
        $id = $_GET['id'] ?? null;
        if ($id !== null) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $updatedRecord = [
                    'username' => validateInput($_POST['username']),
                    'email' => validateInput($_POST['email']),
                    'fecha_registro' => validateInput($_POST['fecha_registro']),
                    'seguidores' => validateInput($_POST['seguidores']),
                    'siguiendo' => validateInput($_POST['siguiendo']),
                    'bio' => validateInput($_POST['bio'])
                ];
                if (updateRecord($data, $id, $updatedRecord)) {
                    writeCSV($file, $data);
                    header('Location: index.php');
                    exit;
                }
            }
            $record = findRecord($data, $id);
            include 'templates/edit.tlp.php';
        }
        break;

    case 'multi_edit':
        //edición de varios registros
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['records'])) {
                foreach ($_POST['records'] as $id => $record) {
                    $updatedRecord = [
                        'username' => validateInput($record['username']),
                        'email' => validateInput($record['email']),
                        'fecha_registro' => validateInput($record['fecha_registro']),
                        'seguidores' => validateInput($record['seguidores']),
                        'siguiendo' => validateInput($record['siguiendo']),
                        'bio' => validateInput($record['bio'])
                    ];
                    updateRecord($data, $id, $updatedRecord);
                }
                writeCSV($file, $data);
                header('Location: index.php');
                exit;
            }
        } else {
            $ids = explode(',', $_GET['ids'] ?? '');
            $selectedRecords = [];
            foreach ($ids as $id) {
                if (isset($data[$id])) {
                    $selectedRecords[$id] = $data[$id];
                }
            }
            include 'templates/multiple_edit.tlp.php';
        }
        break;

    case 'delete':
        //eliminación de registros
        $id = $_GET['id'] ?? null;
        if ($id !== null && deleteRecord($data, $id)) {
            writeCSV($file, $data);
        }
        header('Location: index.php');
        exit;

    case 'view':
        //vista detallada de un registro
        $id = $_GET['id'] ?? null;
        if ($id !== null) {
            $record = findRecord($data, $id);
            include 'templates/view_record.tlp.php';
        }
        break;

    default:
        //edición múltiple y vista por defecto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['multi_action'])) {
            $selectedIds = $_POST['selected'] ?? [];
            $multiAction = $_POST['multi_action'];
    
            if (!empty($selectedIds)) {
                switch ($multiAction) {
                    case 'delete':
                        foreach ($selectedIds as $id) {
                            deleteRecord($data, $id);
                        }
                        writeCSV($file, $data);
                        break;
                    case 'edit':
                        header('Location: index.php?action=multi_edit&ids=' . implode(',', $selectedIds));
                        exit;
                }
            }
        }
        include 'templates/list.tlp.php';
        break;
}
?>
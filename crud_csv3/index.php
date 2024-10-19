<?php
//incluimos las funciones a usar
require_once 'functions.php';

//se obtiene la acción del metodo get, por defecto list, y se craga el csv en un array con fgetcsv
$action = $_GET['action'] ?? 'list';
$filename = './csv//users-table1.csv';
$data = readCSV($filename);

//switch para escoger qué hacer dependiendo de la accion recibida por get
switch ($action) {
    case 'add':
        //si la petición es post se escriben los datos en el csv
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRecord = [
                validateInput($_POST['username']),
                validateInput($_POST['email']),
                validateInput($_POST['fecha_registro']),
                validateInput($_POST['seguidores']),
                validateInput($_POST['siguiendo']),
                validateInput($_POST['bio'])
            ];
            $data[] = $newRecord;
            writeCSV($filename, $data);
            header('Location: index.php');
            exit;
        }
        //se incluye el template correspondiente
        include 'templates/add_form.tlp.php';   
        break;

    case 'edit':
        $id = $_GET['id'] ?? null;
        if ($id !== null) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $updatedRecord = [
                    validateInput($_POST['nombre']),
                    validateInput($_POST['edad']),
                    validateInput($_POST['curso'])
                ];
                if (updateRecord($data, $id, $updatedRecord)) {
                    writeCSV($filename, $data);
                    header('Location: index.php');
                    exit;
                }
            }
            $record = findRecord($data, $id);
            include 'templates/edit_form.tlp.php';
        }
        break;

        case 'bulk_edit':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['records'])) {
                    foreach ($_POST['records'] as $id => $record) {
                        $updatedRecord = [
                            validateInput($record['nombre']),
                            validateInput($record['edad']),
                            validateInput($record['curso'])
                        ];
                        updateRecord($data, $id, $updatedRecord);
                    }
                    writeCSV($filename, $data);
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
                include 'templates/bulk_edit_form.tlp.php';
            }
            break;

    case 'delete':
        $id = $_GET['id'] ?? null;
        if ($id !== null && deleteRecord($data, $id)) {
            writeCSV($filename, $data);
        }
        header('Location: index.php');
        exit;

    case 'view':
        $id = $_GET['id'] ?? null;
        if ($id !== null) {
            $record = findRecord($data, $id);
            include 'templates/view_record.tlp.php';
        }
        break;

    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action'])) {
            $selectedIds = $_POST['selected'] ?? [];
            $bulkAction = $_POST['bulk_action'];

            if (!empty($selectedIds)) {
                switch ($bulkAction) {
                    case 'delete':
                        foreach ($selectedIds as $id) {
                            deleteRecord($data, $id);
                        }
                        writeCSV($filename, $data);
                        break;
                    case 'edit':
                        header('Location: index.php?action=bulk_edit&ids=' . implode(',', $selectedIds));
                        exit;
                }
            }
        }
        include 'templates/list_records.tlp.php';
        break;
}
?>
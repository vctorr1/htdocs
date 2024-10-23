<?php
//Incluimos el archivo de funciones
require_once 'functions.php';

// Verificamos que el directorio csv existe
$csvDir = './csv';
if (!is_dir($csvDir)) {
    mkdir($csvDir, 0777, true);
}

//usamos el get para determinar la accion a realizar
$action = $_GET['action'] ?? 'list';
$file = './csv/users-table1.csv';

// Si el archivo no existe, lo creamos con los encabezados
if (!file_exists($file)) {
    $headers = ['username', 'email', 'fecha_registro', 'seguidores', 'siguiendo', 'bio'];
    $initialData = [
        'headers' => $headers,
        'data' => []
    ];
    writeCSV($file, $initialData);
}

$csvData = readCSV($file);

// Verificar que tenemos los encabezados necesarios
if (empty($csvData['headers'])) {
    $csvData['headers'] = ['username', 'email', 'fecha_registro', 'seguidores', 'siguiendo', 'bio'];
    writeCSV($file, $csvData);
}

//switch principal para manejar diferentes acciones
switch ($action) {
    case 'add':
        // Maneja la creación de nuevos registros
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesa el formulario de creación
            $newRecord = [];
            foreach ($csvData['headers'] as $header) {
                $newRecord[$header] = validateInput($_POST[$header] ?? '');
            }
            $csvData['data'][] = $newRecord;
            if (writeCSV($file, $csvData)) {
                header('Location: index.php');
                exit;
            }
        } // Muestra el formulario de creación
        $bodyOutput = generateCreateHTML();
        include 'templates/create.tlp.php';   
        break;

    case 'multi_edit':
        if (isset($_GET['ids'])) {
            $ids = explode(',', $_GET['ids']);
            $records = [];
            foreach ($ids as $id) {
                $id = (int)$id;
                if (isset($csvData['data'][$id])) {
                    $records[$id] = $csvData['data'][$id];
                }
            }
            $bodyOutput = generateMultiEditHTML($records, $ids);
            include 'templates/edit.tlp.php';
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'multi_edit_save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['records']) && isset($_POST['ids'])) {
            $records = $_POST['records'];
            foreach ($records as $id => $record) {
                $updatedRecord = [];
                foreach ($csvData['headers'] as $header) {
                    $updatedRecord[$header] = validateInput($record[$header] ?? '');
                }
                updateRecord($csvData, $id, $updatedRecord);
            }
            writeCSV($file, $csvData);
            header('Location: index.php');
            exit;
        }
        header('Location: index.php');
        break;

    case 'edit':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id !== null) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $updatedRecord = [];
                foreach ($csvData['headers'] as $header) {
                    $updatedRecord[$header] = validateInput($_POST[$header] ?? '');
                }
                if (updateRecord($csvData, $id, $updatedRecord)) {
                    if (writeCSV($file, $csvData)) {
                        header('Location: index.php');
                        exit;
                    }
                }
            }
            $record = findRecord($csvData, $id);
            if ($record) {
                $bodyOutput = generateEditHTML($record, $id);
                include 'templates/edit.tlp.php';
            } else {
                header('Location: index.php');
                exit;
            }
        } else {
            header('Location: index.php');
            exit;
        }
        break;

    case 'delete':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id !== null && deleteRecord($csvData, $id)) {
            writeCSV($file, $csvData);
        }
        header('Location: index.php');
        exit;

    case 'view':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id !== null) {
            $record = findRecord($csvData, $id);
            if ($record) {
                $bodyOutput = '<h2>Detalles del registro</h2>';
                $bodyOutput .= '<dl>';
                foreach ($record as $key => $value) {
                    $bodyOutput .= '<dt>' . htmlspecialchars($key) . '</dt>';
                    $bodyOutput .= '<dd>' . htmlspecialchars($value) . '</dd>';
                }
                $bodyOutput .= '</dl>';
                $bodyOutput .= '<a href="index.php" class="button">Volver</a>';
                include 'templates/view.tlp.php';
                break;
            }
        }
        header('Location: index.php');
        exit;

    default:
        // Procesar acciones en masa
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action']) && !empty($_POST['selected'])) {
            $selectedIds = isset($_POST['select_all']) ? 
                          array_keys($csvData['data']) : 
                          array_map('intval', $_POST['selected']);
            
            switch ($_POST['bulk_action']) {
                case 'delete':
                    foreach ($selectedIds as $id) {
                        deleteRecord($csvData, $id);
                    }
                    writeCSV($file, $csvData);
                    header('Location: index.php');
                    exit;
                    
                case 'edit':
                    header('Location: index.php?action=multi_edit&ids=' . implode(',', $selectedIds));
                    exit;
            }
        }

        $bodyOutput = generateTableHTML($csvData);
        include 'templates/list.tlp.php';
        break;
}
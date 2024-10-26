<?php
//Incluimos el archivo de funciones
require_once 'functions.php';

//usamos el get para determinar la accion a realizar
$action = $_GET['action'] ?? 'list';
$file = './csv/users-table1.csv';
$csvData = readCSV($file);

//switch principal para manejar diferentes acciones
switch ($action) {
    case 'add':
        //creamos los neuvos registros
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //nuevo id
            $newId = getNextId($csvData);
            $newRecord = ['id' => $newId];

            //añadimos el resto de headers
            foreach ($csvData['headers'] as $header) {
                if ($header !== 'id') {
                    $newRecord[$header] = validateInput($_POST[$header] ?? '');
                }
            }
            //lo mismo pero con los datos
            $csvData['data'][] = $newRecord;
            if (writeCSV($file, $csvData)) {
                header('Location: index.php');
                exit;
            }
        }
        //generamos el html con los encabezados
        $bodyOutput = generateCreateHTML($csvData['headers']);
        include 'templates/create.tlp.php';
        break;

    case 'multi_edit':
        //verificamos si recibimos ids en la url
        //ej: index.php?action=multi_edit&ids=1,2,3
        if (isset($_GET['ids'])) {
            //pasamos los ids recibidos como string por el get a array
            //1,2,3 lo pasamos a ['1','2','3']
            $ids = explode(',', $_GET['ids']);

            $records = [];

            foreach ($ids as $id) {
                //casting de los ids a int en todo el programa por seguridad, junto con validateInput
                $id = (int)$id;

                //si el id existe se añade a los regisros a editar, si no lo ignoramos
                if (isset($csvData['data'][$id])) {
                    $records[$id] = $csvData['data'][$id];
                }
            }

            $bodyOutput = generateMultiEditHTML($records, $ids);

            include 'templates/edit.tlp.php';
        } else {
            //si no recibimos ids volvemos al index
            header('Location: index.php');
            exit;
        }
        break;

    case 'multi_edit_save':
        //verificamos los datos del post
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['records']) &&
            isset($_POST['ids'])
        ) {
            //ej: records[1][username] = "victor"
            $records = $_POST['records'];

            foreach ($records as $id => $record) {
                $updatedRecord = [];

                // Procesa cada campo del registro según los encabezados definidos
                foreach ($csvData['headers'] as $header) {
                    //validamos los campos y si no dejamos vacío
                    $updatedRecord[$header] = validateInput($record[$header] ?? '');
                }

                //actualziamos
                updateRecord($csvData, $id, $updatedRecord);
            }

            //guardamos los cambios
            writeCSV($file, $csvData);

            header('Location: index.php');
            exit;
        }
        header('Location: index.php');
        break;

    case 'edit':
        //obtenemos los ids por get en la url
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id !== null) {
            //actualizamos con los datos obtenidos por post
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

        //vista detallada
    case 'view':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id !== null) {
            $record = findRecord($csvData, $id);
            if ($record) {
                $bodyOutput = generateViewHTML($record);
                include 'templates/view.tlp.php';
                break;
            }
        }
        header('Location: index.php');
        exit;

    default:
        //si no se recibe accion por GET lleva al default que se encargad e listar todos los registros
        //si la pet es post y hay acciones multiples trabajamos sobre ellas
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action']) && !empty($_POST['selected'])) {
            $selectedIds = isset($_POST['select_all']) ?
                array_keys($csvData['data']) :
                //casteamos los ids a enteros dentro del array map
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
                    //convertimos los ids de vuelta a string con implode para redireccionar a la edicion múltiple con su info
                    header('Location: index.php?action=multi_edit&ids=' . implode(',', $selectedIds));
                    exit;
            }
        }

        $bodyOutput = generateTableHTML($csvData);
        include 'templates/list.tlp.php';
        break;
}

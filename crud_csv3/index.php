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
            // Generar nuevo ID
            $newId = getNextId($csvData);
            
            // Crear nuevo registro con ID
            $newRecord = ['id' => $newId];
            
            // Añadir resto de campos excepto ID
            foreach ($csvData['headers'] as $header) {
                if ($header !== 'id') {  // Saltamos el campo ID ya que lo manejamos automáticamente
                    $newRecord[$header] = validateInput($_POST[$header] ?? '');
                }
            }
            
            $csvData['data'][] = $newRecord;
            if (writeCSV($file, $csvData)) {
                header('Location: index.php');
                exit;
            }
        }
        // Generar HTML del formulario sin campo ID
        $bodyOutput = generateCreateHTML($csvData['headers']);
        include 'templates/create.tlp.php';   
        break;

        case 'multi_edit':
            // Verifica si se recibieron IDs en la URL
            // Ejemplo URL: index.php?action=multi_edit&ids=1,2,3
            if (isset($_GET['ids'])) {
                // Convierte el string de IDs separados por comas en un array
                // Ejemplo: "1,2,3" se convierte en ['1','2','3']
                $ids = explode(',', $_GET['ids']);
                
                // Inicializa array para almacenar los registros a editar
                $records = [];
                
                // Itera sobre cada ID recibido
                foreach ($ids as $id) {
                    // Convierte el ID a entero para seguridad
                    // Previene inyección y asegura tipo de dato correcto
                    $id = (int)$id;
                    
                    // Verifica si el registro existe en los datos del CSV
                    if (isset($csvData['data'][$id])) {
                        // Si existe, lo añade al array de registros a editar
                        // Mantiene el ID como índice para posterior referencia
                        $records[$id] = $csvData['data'][$id];
                    }
                    // Si el registro no existe, simplemente lo ignora
                }
                
                // Genera el HTML del formulario de edición múltiple
                // Pasa tanto los registros como los IDs originales
                $bodyOutput = generateMultiEditHTML($records, $ids);
                
                // Incluye la plantilla de edición que mostrará el formulario
                include 'templates/edit.tlp.php';
            } else {
                // Si no se recibieron IDs, redirecciona a la página principal
                header('Location: index.php');
                exit;
            }
            break;

            case 'multi_edit_save':
                // Verifica que:
                // 1. La petición sea POST (envío de formulario)
                // 2. Existan registros en el POST
                // 3. Existan IDs en el POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
                    isset($_POST['records']) && 
                    isset($_POST['ids'])) {
                    
                    // Obtiene los registros enviados del formulario
                    // La estructura es: records[id][campo] = valor
                    // Ejemplo: records[0][username] = "nuevo_nombre"
                    $records = $_POST['records'];
                    
                    // Itera sobre cada registro recibido
                    foreach ($records as $id => $record) {
                        // Prepara array para el registro actualizado
                        $updatedRecord = [];
                        
                        // Procesa cada campo del registro según los encabezados definidos
                        foreach ($csvData['headers'] as $header) {
                            // Sanitiza y valida cada campo
                            // Si el campo no existe, asigna string vacío
                            $updatedRecord[$header] = validateInput($record[$header] ?? '');
                        }
                        
                        // Actualiza el registro en el array de datos
                        // La función updateRecord verifica si el ID existe
                        updateRecord($csvData, $id, $updatedRecord);
                    }
                    
                    // Guarda todos los cambios en el archivo CSV
                    writeCSV($file, $csvData);
                    
                    // Redirecciona a la página principal tras guardar
                    header('Location: index.php');
                    exit;
                }
                
                // Si no se cumplen las condiciones, redirecciona
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

        case 'add_post':
            $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
            
            if ($userId === null || !isset($csvData['data'][$userId])) {
                header('Location: index.php');
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $postsFile = './csv/posts-table.csv';
                $postsData = readCSV($postsFile);
                
                $newPost = [
                    'user_id' => $userId,
                    'title' => validateInput($_POST['title']),
                    'content' => validateInput($_POST['content']),
                    'date' => date('Y-m-d'),
                    'likes' => 0
                ];
                
                $postsData['data'][] = $newPost;
                writeCSV($postsFile, $postsData);
                
                header('Location: index.php');
                exit;
            }
            
            // Mostrar formulario para añadir post
            $bodyOutput = generateAddPostHTML($userId);
            include 'templates/create.tlp.php';
            break;

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
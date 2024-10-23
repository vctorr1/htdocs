<?php
require_once 'functions.php';
require_once 'data_controller.php';

$action = $_GET['action'] ?? 'list_all';
$bodyOutput = '';

switch($action) {
    case 'list_all':
        $bodyOutput = generateTableView();
        require_once 'templates/main.php';
        break;
    case 'bulk_action':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ids = $_POST['selected'] ?? [];
            $operation = $_POST['operation'] ?? '';
            
            if (!empty($ids) && $operation) {
                performBulkOperation($operation, $ids);
            }
            header('Location: index.php');
        }
        break;
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            updateRecords($_POST);
            header('Location: index.php');
        } else {
            $ids = $_GET['ids'] ?? [];
            $bodyOutput = generateEditForm($ids);
            require_once 'templates/main.php';
        }
        break;
    default:
        header('Location: index.php');
}
?>

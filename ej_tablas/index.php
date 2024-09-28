<?php
// Configuración de errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivos necesarios
require_once __DIR__ . '/app/vars.php';
require_once __DIR__ . '/app/functions.php';

// Verificar si las funciones requeridas están definidas
if (!function_exists('getDataFromCSV') || !function_exists('generateJoinedTableMarkup')) {
    die("Error: Las funciones requeridas no están definidas. Verifica el archivo functions.php");
}

// Obtener datos de los archivos CSV
$usersData = getDataFromCSV($usersFile);
$postsData = getDataFromCSV($postsFile);

// Generar el markup HTML para la tabla unida
$joinedTable = generateJoinedTableMarkup($usersData, $postsData);

// Incluir la plantilla para mostrar los resultados
require_once __DIR__ . '/templates/template1.php';
?>
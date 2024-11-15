<?php
session_start();

// login
require_once 'funciones.php';
// Array de productos
require_once 'productos.php';

login();

// inicializar carrito si no existe
getCarrito();

$bodyOutput = printProductsHTML($productos);

// switch para las acciones del producto
if (isset($_POST['accion'])) {
    $id = $_POST['id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

    switch ($_POST['accion']) {
        case 'agregar':
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] += $cantidad;
            } else {
                $_SESSION['carrito'][$id] = $cantidad;
            }
            break;
        case 'actualizar':
            if ($cantidad <= 0) {
                unset($_SESSION['carrito'][$id]);
            } else {
                $_SESSION['carrito'][$id] = $cantidad;
            }
            break;
    }

    header('Location: ' . ($_POST['accion'] === 'agregar' ? 'index.php' : 'carrito.php'));
    exit;
}

// plantilla de productos
include_once 'templates/productos.tlp.php';

<?php
session_start();

require_once 'funciones.php';
require_once 'productos.php';

getCarrito();

// Generar el HTML del carrito con los productos en el array global `$productos`
$bodyOutput = printCarritoHTML($productos);
include_once 'templates/carrito.tlp.php';
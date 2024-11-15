<?php
session_start();

require_once 'funciones.php';
require_once 'productos.php';

getCarrito();

// se genera el html del carrito
$bodyOutput = printCarritoHTML($productos);
include_once 'templates/carrito.tlp.php';
<?php
session_start();

require_once'funciones.php';
require_once'productos.php';

getCarrito();
include_once'templates/carrito.tlp.php';
?>

<?php

//método de inicio de sesión
function login(){
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="carrito_compra"');
        header('HTTP/1.0 401 Unauthorized');
        $html = 'Has cancelado el inicio de sesión';
        exit;
    } else {
        $html = "<p>Hola {$_SERVER['PHP_AUTH_USER']}.</p>";
        $html .= "<p>Has introducido {$_SERVER['PHP_AUTH_PW']} como contraseña</p>";
        $_SESSION["user"] = $_SERVER['PHP_AUTH_USER'];
        $_SESSION["password"] = $_SERVER['PHP_AUTH_PW'];
        dump($_SESSION);
    }
    //redirige a la plantilla del carrito al terminar
    include 'templates/carrito.tlp.php';
    
}

function generateCartMarkup($cart_array){
    $html = '<table>';
    $html = '<th><td>Imagen Prod</td><td>Producto</td><td>Precio</td><td>Acciones</td></th>';
    $html = '<tr><td>'.foreach ($products as $product => $image) {
        # code...
    }.'</td></tr>';   
}



//BORRAR AL TERMINAR
function dump($var){
    echo '<pre>'.print_r($var, true).'</pre>';
}
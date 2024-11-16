<?php

function login() {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="carrito_compra"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
    } else {
        $usuario = "victor";
        $contraseña = "daw";
        if ($usuario == $_SERVER['PHP_AUTH_USER'] && $contraseña == $_SERVER['PHP_AUTH_PW']) {
            $_SESSION["user"] = $_SERVER['PHP_AUTH_USER'];
            $_SESSION["password"] = $_SERVER['PHP_AUTH_PW'];
        }
    }
}

//funcion para obtener el carrito y crearlo si no existe
function getCarrito() {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
}

function printProductsHTML($productos) {
    $html = "";
    foreach ($productos as $producto) {
        $html .= '<div class="producto">';
        $html .= "<h3>{$producto['nombre']}</h3><p>Precio: {$producto['precio']}</p>";
        $html .= "<form method='post'><input type='hidden' name='id' value='{$producto['id']}'>";
        $html .= "<input type='hidden' name='accion' value='agregar'>";
        $html .= "<div class='controles'><button type='button' onclick='restar(this)'>-</button>";
        $html .= "<input type='number' name='cantidad' value='1' min='1'><button type='button' onclick='sumar(this)'>+</button></div>";
        $html .= "<button type='submit'>Añadir al carrito</button></form></div>";
        //al darle a añadir el carrito el formulario se envía al index por post
    }
    $html .= "<a href='carrito.php''>Ver carrito</a>";
    return $html;
}

function printCarritoHTML($productos) {
    $html = '';
    $total = 0;
    foreach ($_SESSION['carrito'] as $id => $cantidad) {
        if (isset($productos[$id])) {
            $subtotal = $productos[$id]['precio'] * $cantidad;
            $total += $subtotal;
            $html .= "<div class='item'><h3>{$productos[$id]['nombre']}</h3><p>Precio: {$productos[$id]['precio']}</p>";
            $html .= "<form method='post' action='index.php'><input type='hidden' name='id' value='$id'>";
            $html .= "<input type='hidden' name='accion' value='actualizar'>";
            $html .= "<div class='controles'><button type='button' onclick='restar(this)'>-</button>";
            $html .= "<input type='number' name='cantidad' value='$cantidad' min='0'>";
            $html .= "<button type='button' onclick='sumar(this)'>+</button><button type='submit'>Actualizar</button></form>";
            $html .= "<p>Subtotal: " . number_format($subtotal, 2) . " €</p></div>";
        }
    }                   //https://www.php.net/manual/en/function.number-format.php
    $html .= "<div class='total'>Total: " . number_format($total, 2) . " €</div>";
    $html .= "<a href='index.php''>Seguir comprando</a>";
    return $html;  
}

// no tengo cojones a hacer que los botones del carrito funcionen solo con php así que lo dejo con js mientras
/*function printCarritoHTML($productos) {
    $html = '';
    $total = 0;
    foreach ($_SESSION['carrito'] as $id => $cantidad) {
        if (isset($productos[$id])) {
            $producto = $productos[$id];
            $subtotal = $producto['precio'] * $cantidad;
            $total += $subtotal;
            $html .= "<div class='item'>";
            $html .= "<h3>{$producto['nombre']}</h3>";
            $html .= "<p>Precio: " . number_format($producto['precio'], 2) . " €</p>";
            // un formulario solo para el boton de restar
            $html .= "<form method='post' style='display: inline;'>";
            $html .= "<input type='hidden' name='id' value='$id'>";
            $html .= "<input type='hidden' name='accion' value='actualizar'>";
            $html .= "<input type='hidden' name='cantidad' value='" . max(0, $cantidad - 1) . "'>";
            $html .= "<button type='submit'>-</button>";
            $html .= "</form>";
            $html .= "<span>$cantidad</span>";
            // otro formulario solo para el de sumar (así no face falta enviar el formulario con javascript)
            $html .= "<form method='post' style='display: inline;'>";
            $html .= "<input type='hidden' name='id' value='$id'>";
            $html .= "<input type='hidden' name='accion' value='actualizar'>";
            $html .= "<input type='hidden' name='cantidad' value='" . ($cantidad + 1) . "'>";
            $html .= "<button type='submit'>+</button>";
            $html .= "</form>";
            $html .= "<p>Subtotal: " . number_format($subtotal, 2) . " €</p>";
            $html .= "</div>";
        }
    }
    $html .= "<div class='total'>";
    $html .= "<h2>Total: " . number_format($total, 2) . " €</h2>";
    $html .= "</div>";
    $html .= "<a href='index.php'>Seguir comprando</a>";

    return $html;
}*/
?>

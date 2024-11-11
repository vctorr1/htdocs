<?php

$productos = [
    1 => ['id' => 1, 'nombre' => 'Manzana', 'precio' => 10.99],
    2 => ['id' => 2, 'nombre' => 'Plátano', 'precio' => 20.99],
    3 => ['id' => 3, 'nombre' => 'VW GOlf GTI', 'precio' => 35000.99],
    4 => ['id' => 4, 'nombre' => 'Calcetines', 'precio' => 9.99]
];

foreach ($productos as $key => $value) {
    print("<br>");
    foreach ($value as $clave => $valor) {
        print($valor." ");
    }
}
print($productos['1']['nombre']);
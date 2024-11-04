<?php
$contador_visitas = 1;

//asignamos el valor de las cookies como el valor del contador si existe y sumamos 1
if (isset($_COOKIE['contador_visitas'])) {
    $contador_visitas = $_COOKIE['contador_visitas'];
    $contador_visitas++;
}
//setcookies y recuperamos el resultado
setcookie('contador_visitas', $contador_visitas);
$bodyOutput = "Has visitado la web " . $contador_visitas . " veces.";

include('view.php');
?>

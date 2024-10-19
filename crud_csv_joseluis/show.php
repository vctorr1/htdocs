<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('./includes/funciones.inc');
include_once('./includes/env.inc');

setErrorHandlers();


//zona de variables globales
$bodyOutput = '';


/** obtenemos los datos d la query string*/
$abreviatura_id = filter_input(INPUT_GET, 'abreviatura_id', FILTER_SANITIZE_ENCODED);
if(isset($abreviatura_id)&&(!empty($abreviatura_id))){
    //asumimos que abreviatura_id tiene un identificador
    $registro = getRegistroFromCSV('./resources/csv/resultados.csv', 'abreviatura_id', $abreviatura_id);
    if(isset($registro)&&(!empty($registro))){
        $bodyOutput = getMarkup($registro);
    }else{
        header("HTTP/1.1 404 Not Found");
        die;
    }

}else{
    $bodyOutput = '<p>No se puede encontrar el registro solicitado</p>';
}


/*echo dirname(__FILE__);
$boton_enviar_formulario = filter_input(INPUT_POST, 'boton_enviar');
if(isset($boton_enviar_formulario)){

}else{
    include('./templates/create.tpl.php');
}*/


include('./templates/show.tpl.php');
<?php

include_once('./includes/env.inc');
include_once('./includes/funciones.inc');

setErrorHandlers();


//Zona de variables globles
$bodyOutput = '';

//Obtenemos los datos de la query string, en particular el abreviatura_id
$abreviatura_id = filter_input(INPUT_GET, 'abreviatura_id', FILTER_SANITIZE_ENCODED);
if(isset($abreviatura_id)&&(!empty($abreviatura_id))){
    //Asumimos que abreviatura_id tiene un identificador
    $registro = getRegistroFromCSV('./resources/csv/resultados.csv','abreviatura_id', $abreviatura_id);
    if((isset($registro))&&(!empty($registro))){
        $bodyOutput = getResultadoMarkup($registro);
    }else{
        header("HTTP/1.1 404 Not Found");
        die;
    }
    
    

}else{
    $bodyOutput = '<p>No se puede encontra el registro solicitado</p>';
}




include('./templates/show.tpl.php');

?>
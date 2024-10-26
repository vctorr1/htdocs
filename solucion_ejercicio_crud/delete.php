<?php
    include_once('./includes/env.inc');
    include_once('./includes/funciones.inc');
    
    setErrorHandlers();

    if((isset($_GET['seleccionado']))&&(!empty($_GET['seleccionado']))&&(is_array($_GET['seleccionado']))){
        borrarRegistros('./resources/csv/resultados.csv', $_GET['seleccionado'] , 'abreviatura_id');

    }
?>
<?php

include_once('./includes/env.inc');
include_once('./includes/funciones.inc');

setErrorHandlers();


//Zona de variables globles
$bodyOutput = '';


$boton_enviar_formulario = filter_input(INPUT_POST, 'boton_enviar');
if(isset($boton_enviar_formulario)){
    if(isset($_POST['seleccionado'])&&(is_array($_POST['seleccionado']))){
        //Existen elementos seleccionados

        $ids_seleccionados = [
            'seleccionado' => array_keys($_POST['seleccionado']),
        ];

        //Comprobamos operación seleccionada
        switch($_POST['operacion']){
            case 'eliminar':
                $queryString = http_build_query($ids_seleccionados);

                header('Location: ./delete.php?'.$queryString);
                die;
            break;
            case 'editar':
                header('Location: ./update.php?'.$queryString);
                die;
            break;
        }
    }
    
}
$registros = getRegistrosFromCSV('./resources/csv/resultados.csv');
   
$bodyOutput = getTableMarkup($registros);
include('./templates/index.tpl.php');    
    


?>
<?php

include_once('./includes/env.inc');
include_once('./includes/funciones.inc');

setErrorHandlers();

$mensajesUsuario = '';

$boton_enviar_formulario = filter_input(INPUT_POST, 'boton_enviar');
if(isset($boton_enviar_formulario)){
    
    $filtros = [
        'name' => FILTER_UNSAFE_RAW,
        'descripcion' => FILTER_UNSAFE_RAW,
        'orden' => FILTER_SANITIZE_NUMBER_INT,
        'modulo_id' => FILTER_UNSAFE_RAW,
        'abreviatura_id' => FILTER_UNSAFE_RAW,
    ]; 
    $datosFiltrados = filter_input_array(INPUT_POST, $filtros);
    
    
    if(in_array(true, array_map('validacionIncorrecta',$datosFiltrados))){
        //Validación incorrecta
        $mensajesUsuario = '<p>Falló la validación de datos</p>';
        include('./templates/create.tpl.php'); 
        die;   
    }
    
    //Si llega aquí es porque los datos son válidos
    guardarRegistro('./resources/csv/resultados.csv',$datosFiltrados);
    header('Location: index.php');
    die;
    
}else{
    include('./templates/create.tpl.php');
}


?>
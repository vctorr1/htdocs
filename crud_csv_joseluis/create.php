<?php

include_once('./includes/env.inc');
include_once('./includes/funciones.inc');

$mensajesUsuario = '';

echo dirname(__FILE__);
$boton_enviar_formulario = filter_input(INPUT_POST, 'boton_enviar');
if(isset($boton_enviar_formulario)){

    $filtros = [
        'name' => FILTER_SANITIZE_ENCODED,
        'descripcion' => FILTER_UNSAFE_RAW,
        'orden' => FILTER_SANITIZE_NUMBER_INT,
        'modulo_id' => FILTER_UNSAFE_RAW,  
    ];
    //filter_input_array accede a los datos del post
    $datosFiltrados = filter_input_array(INPUT_POST,$filtros);
    //$validades = array_map("validacionIncorrecta",$datosFiltrados);
    if (in_array(true,array_map("validacionIncorrecta",$datosFiltrados))) {
        //validación incorrecta
        $mensajesUsuario = 'Falló la validación de datos';
        include('./templates/create.tlp.php');
        die;
    }
    //si llegas aquí es porque los datos son válidos
    guardarRegistro('./resources/csv/users-table1.csv', $datosFiltrados);
    header('Location: index.php');
    die;

    dump($datosFiltrados);
}else{
    include('./templates/create.tpl.php');
}
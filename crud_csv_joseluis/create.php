<?php


echo dirname(__FILE__);
$boton_enviar_formulario = filter_input(INPUT_POST, 'boton_enviar');
if(isset($boton_enviar_formulario)){

}else{
    include('./templates/create.tpl.php');
}
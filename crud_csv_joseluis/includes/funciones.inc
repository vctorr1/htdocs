<?php

function dump($var){
    echo '<pre>'.print_r($var,true).'</pre>';
}

function getRegistroFromCSV(String $path, String $campo_id, String $valor_id){
    $registroDevuelto = null;

    $manejadorFichero = fopen($path, "r");
    $cabeceras = fgetcsv($manejadorFichero);
    //le pasas un valor y un array, y te pasa si existe en el array
    if(in_array($campo_id, $cabeceras)){
        dump("El campo $campo_id existe en el archivo.");
        while ($fila = fgetcsv($manejadorFichero)) {
            $prov = array_combine($cabeceras, $fila);
            dump("Estoy comprobando la fila $fila");
            if ($prov[$campo_id] == $valor_id) {
                //lo he encontrado
                return $prov;
            }
        }
    }

    return $registroDevuelto;
}

function getResultadoMarkup($resultado){
    $output = '';
    $output = '<h2>'.$resultado['nombre'].'</h2>';
    $output = 'p><small><strong>Orden:</strong></small></p>';

}

function setErrorHandlers(){
    if(ENV_MODE == 'prod'){
        //dump('estamos en modo produccion');
        set_error_handler('prodErrorHandler');
        set_exception_handler('prodErrorHandler');
    }else if(ENV_MODE == 'dev'){
        //dump('estamos en modo desarrollo');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        set_error_handler('devErrorHandler');
    }
};

function devErrorHandler($errno, $errstr, $errfile, $errline){
    throw new Exception("Error number: ".$errno."\nError file: ".$errfile."\nError message: ".$errstr."\nError line: ".$errline);   
    include('templates/error.tlp.php');
    die;
}

function prodExceptionHandler($exception){
    include('templates/error.tlp.php');
    die;
}

function prodErrorHandler($errno, $errstr, $errfile, $errline){
    include('templates/error.tlp.php');
    die;
}

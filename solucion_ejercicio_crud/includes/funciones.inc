<?php

function dump($var){
    echo '<pre>'.print_r($var,true).'</pre>';
}
function setErrorHandlers(){
    if(ENV_MODE == 'prod'){
        // Set user-defined error handler function
        set_error_handler("prodErrorHandler");
        set_exception_handler("prodExceptionHandler");
    }else if(ENV_MODE == 'dev'){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        set_error_handler("devErrorHandler");
    }
}
function prodExceptionHandler($exception){
    include('templates/error.tpl.php');
    die;
}
function prodErrorHandler($errno, $errstr, $errfile, $errline){
    //Hacemos que los errores arrojen exepciones
    include('templates/error.tpl.php');
    die;
}
function devErrorHandler($errno, $errstr, $errfile, $errline){
    //Hacemos que los errores arrojen exepciones
    throw new Exception("Error number: ".$errno."\nError Message: ".$errstr."\nError file: ".$errfile."\nError Line: ".$errline);
}

function getResultadoMarkup($resultado){
    $output = '';
    $output.='<h2>'.$resultado['nombre'].'</h2>';
    $output.='<p><small><strong>Orden:</strong> '.$resultado['orden'].'</small></p>';
    $output.='<p>'.$resultado['descripcion'].'</p>';
    
    return $output;
}

function validacionIncorrecta($valor){
    return empty($valor);
}

function guardarRegistro($path, $registro){
    $manejadorFichero = fopen($path, 'a+');
    fputcsv($manejadorFichero,$registro ,eol:PHP_EOL);
    
    fclose($manejadorFichero);
}

function getRegistrosFromCSV(String $path){
    $manejadorFichero = fopen($path, 'r');

    $cabeceras = fgetcsv($manejadorFichero);
    $resultado = [];
    while($fila = fgetcsv($manejadorFichero)){
        $resultado[] = array_combine($cabeceras,$fila);
            
        }
    return $resultado;
}

function getTableMarkup($registros){
    
    $cabeceras = array_keys($registros[0]);
    $output = '<table>';
    $output .= '<thead>';
    $output .= '<th>&nbsp;</th>';
    foreach($cabeceras as $cabecera){
        $output .= '<th>'.ucfirst($cabecera).'</th>';
    }
    $output .= '<th>&nbsp;</th>';
    $output .= '</thead>';
    $output .= '<tbody>';
    foreach($registros as $item){
        $output .= '<tr>';
        $output .= '<td><input type="checkbox" name="seleccionado['.$item['abreviatura_id'].']" value="'.$item['abreviatura_id'].'"></td>';
        foreach($item as $valorCampo){
            $output .= '<td>'.$valorCampo.'</td>';
        }
        $output .= '<td><a href="show.php?abreviatura_id='.$item['abreviatura_id'].'">Ver</a></td>';
        $output .= '</tr>';
    }
    $output .= '</tbody>';  
    $output .= '</table>';
    return $output;
}

function borrarRegistros($path, $seleccionados , $clave){
    
    $registros = getRegistrosFromCSV($path);
    dump($registros);
    dump($seleccionados);
    //VAMOS POR AQUÍ
    
    
}

function getRegistroFromCSV(String $path, String $campo_id, String $valor_id){
    
    $registroDevuelto = null;
    
    $manejadorFichero = fopen($path, 'r');

    $cabeceras = fgetcsv($manejadorFichero);
    
    if(in_array($campo_id, $cabeceras)){
        //dump("El campo $campo_id existe en el archivo");
        while($fila = fgetcsv($manejadorFichero)){
            $prov = array_combine($cabeceras,$fila);
            if($prov[$campo_id] == $valor_id){
                //Lo he encontrado    
                return $prov;
            }
        }
    }
    return $registroDevuelto;
}
<?php   //Se usa para indicar lo que tiene que devolver la función
function getArrayFromCSV($csvUrl):array{
    //Devuelve un array asociativo con la información contenida en el csv que se encuentra en la url que se le pasa como parámetro

    $filas = explode("\n",file_get_contents($csvUrl));

    $nombreCols = explode(',', array_shift($filas));

    array_walk($filas,'divide_columnas', $nombreCols);

    return $filas;
}
function divide_columnas(&$arrayItem, $key, $nombreCols){

    $arrayItem = array_combine($nombreCols, str_getcsv($arrayItem));

}

function getTableMarkup(array $arrayTabla){
    $cabeceras = array_keys($arrayTabla[0]);
    $output = "<table>
    <tr>";

    foreach($cabeceras as $cabecera){
        $output .= "<th>".$cabecera."</th>";
    }

    $output .= "</tr>";
    foreach($arrayTabla as $itemTabla){
        $output .= "<td>".$itemTabla. "</td>";
    }
    $output .= "</table>";
    return $output;
}

function getListMarkup(array $list){
    $output = '';
    $output .= '<ul>';
    foreach($list as $clave=>$valor){
        $output.='<li>';
        if(is_array($valor)){
            //Hay que imprimir la lista representada
            $output.= getListMarkup($valor);
        }else{
            //Hay que imprimir el valor
            $output.= $valor;
        }
        $output.='</li>';
    }
    $output .= '</ul>';
    return $output;
}
function dump($var){
    echo '<pre>'.print_r($var, true).'</pre>';
}
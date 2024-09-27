<?php
function getListFromDB(){
    //Simulamos que este método recupera una lista con el contenido de una consulta
    $resultado = array(0=>"Lo que el viento se llevó.","precio"=>"15€","ISBN"=>2744554,3=>"George Miller");
    
    return $resultado;
    //TODO: Se devuelve un array asociativo que representa una lista. 
    //Esta función en realidad haría una consulta a una DB, pero de momento esa parte nos la 'saltamos'.

}
function getListMarkup(array $list){
    $output = "";
    $output .= "<ul>";
    //TODO: Generar marcado de lista a partir del array asociativo list
    //Bucle foreach para recorrer el array e imprimir los valores del mismo
    foreach ($list as $clave => $valor) {
        //Usamos etiquetas html que añadimos también a la salida
        $output .= '<li>'.$clave." => ".$valor."</li>";
        
    }
    //Terminamos cerrando la lista y devolviendo el output
    $output .= " </ul>";
    return $output;
}

?>

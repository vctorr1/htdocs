<?php

/*function listGamesTable($videojuegos)
{
    $html = '<table>';

    foreach ($videojuegos as $x => $y) {
        $html .= '';
    }
}*/
function generateSelectionForm()
{
    $html = '<form action="index.php?accion=filtrar"> method="post">';
    $html = '<input type="checkbox" name="letra" value="A"><label for="A">A</label>' . '<input type="checkbox" name="B" value="B"><label for="B">B</label>' . '<input type="checkbox" name="C" value="C"><label for="C">C</label>' . '<input type="checkbox" name="D" value="D"><label for="D">D</label>' .'<input type="checkbox" name="E" value="E"><label for="E">E</label>' . '<input type="checkbox" name="F" value="F"><label for="F">F</label>'. '<input type="checkbox" name="G" value="G"><label for="G">G</label>'. '<input type="checkbox" name="H" value="H"><label for="H">H</label>'. '<input type="checkbox" name="I" value="I"><label for="I">I</label>'
    . '<input type="checkbox" name="J" value="J"><label for="J">J</label>'. '<input type="checkbox" name="K" value="K"><label for="K">K</label>'. '<input type="checkbox" name="L" value="L"><label for="L">L</label>'. '<input type="checkbox" name="M" value="M"><label for="M">M</label>'. '<input type="checkbox" name="N" value="N"><label for="N">N</label>'. '<input type="checkbox" name="O" value="O"><label for="O">O</label>'. '<input type="checkbox" name="P" value="P"><label for="P">P</label>'
    . '<input type="checkbox" name="Q" value="Q"><label for="Q">Q</label>'. '<input type="checkbox" name="R" value="R"><label for="R">R</label>'. '<input type="checkbox" name="S" value="S"><label for="S">S</label>'. '<input type="checkbox" name="T" value="T"><label for="T">T</label>'. '<input type="checkbox" name="U" value="U"><label for="U">U</label>'. '<input type="checkbox" name="V" value="V"><label for="V">V</label>'. '<input type="checkbox" name="W" value="W"><label for="W">W</label>'
    . '<input type="checkbox" name="X" value="X"><label for="X">X</label>'. '<input type="checkbox" name="Y" value="Y"><label for="Y">Y</label>'. '<input type="checkbox" name="Z" value="Z"><label for="Z">Z</label>'; //Seguir
    $html .= '<input type="submit" value="Filtrar">';
    $html .= '</form>';
    return $html;
}

function generateTable($videojuegos){
    $html = '<table>';
    $html .= '<tr><td><strong>Nombre</strong></td><td><strong>Creador</strong></td><td><strong>Año</strong></td></tr>';
    $html .= '<tr><td>'.$videojuegos[0]['nombre'].'</td><td>'.$videojuegos[0]['creador'].'</td><td>'.$videojuegos[0]['fecha'].'</td></tr>';
    foreach ($videojuegos as $key => $value) {
        /*ARREGLAR PARA QUE SE AÑADAN FECHAS TAMBIEN*/
        $html .= '<tr><td>'.$videojuegos[$key]['nombre'].'</td><td>'.$videojuegos[$key]['creador'].'</td><td>'.$videojuegos[$key]['anio'].'</td></tr>';
    }
    $html .= '</table>';

    return $html;
}
//no va todavía ups
function filtrarTabla($videojuegos){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreJuego = $_POST['letra'];
        $videojuegosFiltrados = [];
        foreach ($videojuegos as $key => $value) {
            if (str_starts_with($value, $nombreJuego)) {
                $videojuegosFiltrados .=$key . $value;
            }
        }
        return $videojuegosFiltrados;

    }
};

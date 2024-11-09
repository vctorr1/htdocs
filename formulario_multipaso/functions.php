<?php

//función para generar el markup con un switch para escoger el paso del formulario
function generateMarkup($step) {
    // Contenedor principal del formulario
    $html = '<div class="container">';
    //tenemos que usar enctype para subir la imagen
    //https://www.w3schools.com/tags/att_form_enctype.asp
    $html .= '<form action="./index.php" method="POST" enctype="multipart/form-data">';

    switch($step) {
        case 1:
            //primera página con la selección del sexo
            $html .= '<h2>Información Básica</h2>';
            $html .= '<div class="form-group">';
            $html .= '<label>Sexo:</label>';
            //si el valor existe en la sesión lo mantenemos
            $html .= '<select name="sexo" required>';
            $html .= '<option value="masculino"' . (isset($_SESSION['sexo']) && $_SESSION['sexo'] == 'masculino' ? ' selected' : '') . '>Masculino</option>';
            $html .= '<option value="femenino"' . (isset($_SESSION['sexo']) && $_SESSION['sexo'] == 'femenino' ? ' selected' : '') . '>Femenino</option>';
            $html .= '<option value="porfavor"' . (isset($_SESSION['sexo']) && $_SESSION['sexo'] == 'porfavor' ? ' selected' : '') . '>Porfavor</option>';
            $html .= '</select>';
            $html .= '</div>';
            break;
            
        case 2:
            //parte de la selección de msuculos
            $html .= '<h2>Selección de Músculos</h2>';
            //guardamos los musculos disponibles en un arary
            $musculos = ['pectorales', 'bíceps', 'tríceps', 'glúteos', 'cuádriceps'];
            $html .= '<div class="form-group">';
            $html .= '<label>Seleccione el músculo a mejorar:</label>';
            //usamos radiobuttons para los musculos
            foreach($musculos as $musculo) {
                //si existe sesión lo mantenemos seleccionado
                $checked = isset($_SESSION['musculo']) && $_SESSION['musculo'] == $musculo ? ' checked' : '';
                $html .= "<div><input type='radio' name='musculo' value='$musculo'$checked required> " . ucfirst($musculo) . "</div>";
            }
            $html .= '</div>';
            break;
            
        case 3:
            //parte de los resultados actuales del ejercicio
            $html .= '<h2>Rendimiento Actual</h2>';
            $html .= '<div class="form-group">';
            $html .= '<label>Peso actual (kg):</label>';
            $html .= '<input type="number" name="peso" value="' . ($_SESSION['peso'] ?? '') . '" required>';
            $html .= '</div>';
            $html .= '<div class="form-group">';
            $html .= '<label>Repeticiones al fallo:</label>';
            $html .= '<input type="number" name="repeticiones" value="' . ($_SESSION['repeticiones'] ?? '') . '" required>';
            $html .= '</div>';
            break;
            
        case 4:
            //paso para la info personal y la foto
            $html .= '<h2>Información Personal</h2>';
            $html .= '<div class="form-group">';
            $html .= '<label>Nombre:</label>';
            $html .= '<input type="text" name="nombre" value="' . ($_SESSION['nombre'] ?? '') . '" required>';
            $html .= '</div>';
            $html .= '<div class="form-group">';
            $html .= '<label>Email:</label>';
            $html .= '<input type="email" name="email" value="' . ($_SESSION['email'] ?? '') . '" required>';
            $html .= '</div>';
            $html .= '<div class="form-group">';
            $html .= '<label>Foto de perfil (jpg o png):</label>';
            //el accept vale para que sólo deje subir los formatos de archivo q le digamos, de imagen en este caso
            $html .= '<input type="file" name="foto" accept=".jpg,.jpeg,.png" required>';
            $html .= '</div>';
            break;
            
        case 5:
            //para los cálculos primero recuperamos los datos de la sesion
            $reps_actuales = $_SESSION['repeticiones'];
            $peso_actual = $_SESSION['peso'];
            
            //almacenamos las propuestas de mejora (usamos round para que no vaya a dar números raros al usuario)
            $mejora_3_meses = round($reps_actuales * 1.5); //la del 50%
            $mejora_6_meses = round($reps_actuales * 2);   //la del doble
            $mejora_peso_3_meses = round($peso_actual * 1.2, 1); //y del 20% solo
            
            //resumen final
            $html .= '<h2>Plan Personalizado</h2>';
            $html .= '<div class="result-card">';
            //mostramos la foto
            if (isset($_SESSION['foto_path'])) {
                $html .= '<img src="' . $_SESSION['foto_path'] . '" alt="foto de perfil">';
            }
            //el resto de la información
            $html .= '<h3>Información Personal</h3>';
            $html .= '<p>Nombre: ' . ($_SESSION['nombre'] ?? '') . '</p>';
            $html .= '<p>Email: ' . ($_SESSION['email'] ?? '') . '</p>';
            $html .= '<p>Músculo seleccionado: ' .($_SESSION['musculo'] ?? '') . '</p>';
            
            //y los resultados del plan de mejora
            $html .= '<h3>Plan de Mejora</h3>';
            $html .= '<p>Rendimiento actual: ' . $peso_actual . 'kg x ' . $reps_actuales . ' repeticiones.</p>';
            $html .= '<div class="mejoras">';
            $html .= '<h4>Objetivos a 3 meses:</h4>';
            $html .= '<ul>';
            $html .= '<li>Repeticiones objetivo: ' . $mejora_3_meses . ' reps (50% más)</li>';
            $html .= '<li>Peso objetivo: ' . $mejora_peso_3_meses . 'kg (20% más)</li>';
            $html .= '</ul>';
            $html .= '<h4>Objetivos a 6 meses:</h4>';
            $html .= '<ul>';
            $html .= '<li>Repeticiones objetivo: ' . $mejora_6_meses . ' reps (100% más)</li>';
            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</div>';
            break;
    }
    
    //los botones de navegacion
    $html .= '<div>';
    //el boton de ir atrás solo lo mosttramos si estamos del 2º paso para adelante
    if ($step > 1) {
        $html .= '<button type="submit" name="prev">Atrás</button>';
    }
    //con el de aldeante igual pero al revés
    if ($step < 5) {
        $html .= '<button type="submit" name="next">Siguiente</button>';
    }
    $html .= '</div>';
    $html .= '</form></div>';
    
    return $html;
}
<?php
session_start();

// Función para generar el HTML según el paso actual
function generateMarkup($step) {
    $html = '<div class="container">';
    $html .= '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST" enctype="multipart/form-data">';
    
    switch($step) {
        case 1:
            $html .= '<h2>Paso 1: Información Básica</h2>';
            $html .= '<div class="form-group">';
            $html .= '<label>Sexo biológico:</label>';
            $html .= '<select name="sexo" required>';
            $html .= '<option value="masculino"' . (isset($_SESSION['sexo']) && $_SESSION['sexo'] == 'masculino' ? ' selected' : '') . '>Masculino</option>';
            $html .= '<option value="femenino"' . (isset($_SESSION['sexo']) && $_SESSION['sexo'] == 'femenino' ? ' selected' : '') . '>Femenino</option>';
            $html .= '</select>';
            $html .= '</div>';
            break;
            
        case 2:
            $html .= '<h2>Paso 2: Selección de Músculos</h2>';
            $musculos = ['pectorales', 'bíceps', 'tríceps', 'glúteos', 'cuádriceps'];
            $html .= '<div class="form-group">';
            $html .= '<label>Seleccione el músculo a mejorar:</label>';
            foreach($musculos as $musculo) {
                $checked = isset($_SESSION['musculo']) && $_SESSION['musculo'] == $musculo ? ' checked' : '';
                $html .= "<div><input type='radio' name='musculo' value='$musculo'$checked required> " . ucfirst($musculo) . "</div>";
            }
            $html .= '</div>';
            break;
            
        case 3:
            $html .= '<h2>Paso 3: Rendimiento Actual</h2>';
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
            $html .= '<h2>Paso 4: Información Personal</h2>';
            $html .= '<div class="form-group">';
            $html .= '<label>Nombre:</label>';
            $html .= '<input type="text" name="nombre" value="' . ($_SESSION['nombre'] ?? '') . '" required>';
            $html .= '</div>';
            $html .= '<div class="form-group">';
            $html .= '<label>Email:</label>';
            $html .= '<input type="email" name="email" value="' . ($_SESSION['email'] ?? '') . '" required>';
            $html .= '</div>';
            $html .= '<div class="form-group">';
            $html .= '<label>Foto de perfil:</label>';
            $html .= '<input type="file" name="foto" accept=".jpg,.jpeg,.png" required>';
            $html .= '</div>';
            break;
            
        case 5:
            // Cálculos de mejora
            $reps_actuales = $_SESSION['repeticiones'] ?? 0;
            $peso_actual = $_SESSION['peso'] ?? 0;
            
            $mejora_3_meses = round($reps_actuales * 1.5);
            $mejora_6_meses = round($reps_actuales * 2);
            $mejora_peso_3_meses = round($peso_actual * 1.2, 1);
            
            $html .= '<h2>Tu Plan Personalizado</h2>';
            $html .= '<div class="result-card">';
            if (isset($_SESSION['foto_path'])) {
                $html .= '<img src="' . $_SESSION['foto_path'] . '" alt="Foto de perfil" style="max-width: 200px;">';
            }
            $html .= '<h3>Información Personal</h3>';
            $html .= '<p>Nombre: ' . ($_SESSION['nombre'] ?? '') . '</p>';
            $html .= '<p>Email: ' . ($_SESSION['email'] ?? '') . '</p>';
            $html .= '<p>Músculo seleccionado: ' . ucfirst($_SESSION['musculo'] ?? '') . '</p>';
            
            $html .= '<h3>Plan de Mejora</h3>';
            $html .= '<p>Rendimiento actual: ' . $peso_actual . 'kg x ' . $reps_actuales . ' repeticiones</p>';
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
    
    $html .= '<div class="navigation-buttons">';
    if ($step > 1) {
        $html .= '<button type="submit" name="prev">Anterior</button>';
    }
    if ($step < 5) {
        $html .= '<button type="submit" name="next">Siguiente</button>';
    }
    $html .= '</div>';
    $html .= '</form></div>';
    
    return $html;
}

// Manejo del estado del formulario
$current_step = $_SESSION['step'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['next'])) {
        // Guardar datos del paso actual
        switch($current_step) {
            case 1:
                $_SESSION['sexo'] = $_POST['sexo'];
                break;
            case 2:
                $_SESSION['musculo'] = $_POST['musculo'];
                break;
            case 3:
                $_SESSION['peso'] = $_POST['peso'];
                $_SESSION['repeticiones'] = $_POST['repeticiones'];
                break;
            case 4:
                $_SESSION['nombre'] = $_POST['nombre'];
                $_SESSION['email'] = $_POST['email'];
                
                // Manejo de la foto
                if (isset($_FILES['foto'])) {
                    $file = $_FILES['foto'];
                    $allowed_types = ['image/jpeg', 'image/png'];
                    $max_size = 5 * 1024 * 1024; // 5MB
                    
                    if (!in_array($file['type'], $allowed_types)) {
                        $error = "Error: Solo se permiten archivos JPG y PNG.";
                    } elseif ($file['size'] > $max_size) {
                        $error = "Error: El archivo es demasiado grande.";
                    } else {
                        $upload_dir = 'uploads/';
                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir);
                        }
                        
                        $filename = uniqid() . '_' . basename($file['name']);
                        $upload_path = $upload_dir . $filename;
                        
                        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                            $_SESSION['foto_path'] = $upload_path;
                        } else {
                            $error = "Error al subir el archivo.";
                        }
                    }
                }
                break;
        }
        
        if (!isset($error)) {
            $current_step++;
        }
    } elseif (isset($_POST['prev'])) {
        $current_step--;
    }
}

$_SESSION['step'] = $current_step;

// Estilos CSS básicos
$styles = '
<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .navigation-buttons {
        margin-top: 20px;
    }
    .navigation-buttons button {
        margin-right: 10px;
        padding: 10px 20px;
    }
    .result-card {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        margin-top: 20px;
    }
    .mejoras {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-top: 15px;
    }
</style>
';

// Mostrar errores si existen
if (isset($error)) {
    echo '<div style="color: red; margin-bottom: 15px;">' . $error . '</div>';
}

// Generar y mostrar el formulario
echo $styles;
echo generateMarkup($current_step);
?>
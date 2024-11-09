<?php
//iniciamos la sesión para mantener los datos entre los pasos del formulario
session_start();

require_once 'functions.php';

//para el forulario, recuperamos el paso en el que nos quedamos y si no nos lleva al primero
$current_step = $_SESSION['step'] ?? 1;

//procesamos el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['next'])) {
        //guardamos los datos actuales en la sesión
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
                
                //subimos la foto
                if (isset($_FILES['foto'])) {
                    $file = $_FILES['foto'];
                    //hay que decirle los formatos que soporta
                    $allowed_types = ['image/jpeg', 'image/png'];
                    $max_size = 5 * 1024 * 1024; //5MB pero tenemos que decirle el tamaño en bytes
                    
                    //validamos el archivo
                    if (!in_array($file['type'], $allowed_types)) {
                        $error = "Error: Solo se permiten archivos jpg y png";
                    } elseif ($file['size'] > $max_size) {
                        $error = "Error: El archivo es demasiado grande.";
                    } else {
                        //señalamos el directorio para las imagenes
                        $upload_dir = 'uploads/';
                        
                        
                        //(entiendo que gestionar el nombre del archivo es crearle uno aleatorio y único)
                        //este hilo me ayudó con esta parte https://laracasts.com/discuss/channels/general-discussion/how-to-generate-long-unique-name-for-filename?page=1
                        $filename = uniqid() . '_' . basename($file['name']);
                        $upload_path = $upload_dir . $filename;
                        
                        //validamos q el archivo se ha subido por post y movemos el archivo temporal subido a uploads y de paso le cambiamos el nombre
                        //https://stackoverflow.com/questions/37008227/what-is-the-difference-between-name-and-tmp-name
                        //https://www.php.net/manual/en/function.move-uploaded-file.php devuelve true al funcionar
                        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                            $_SESSION['foto_path'] = $upload_path;
                        } else {
                            $error = "Error al subir el archivo.";
                        }
                    }
                }
                break;
        }
        
        //si no hay errores entonces pasamos al siguente paso del formulario
        if (!isset($error)) {
            $current_step++;
        }
    } elseif (isset($_POST['prev'])) {
        //si le damos al boton de Atrás pues vamos para atrás
        $current_step--;
    }
}

//actualizamos el paso en la sesión también
$_SESSION['step'] = $current_step;



// Generamos y mostramos el formulario
$bodyOutput = generateMarkup($current_step);
include 'templates/body.tlp.php';

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Registros</title>
    <!-- Minified version -->
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
   
</head>
<body>

    <h1>Lista de Registros</h1>

    <!-- Botón para añadir registros -->
    <a href="./create.php"></a>

    <!-- Select para elegir la operación a realizar -->
    <form id="operacion-form" method="post" action="./index.php">
        <label for="operacion">Seleccionar operación:</label>
        <select id="operacion" name="operacion">
            <option value="eliminar">Eliminar</option>
            <option value="editar">Editar</option>
        </select>
        <button type="submit" class="action-btn">Aplicar a seleccionados</button>
    </form>

    <!-- Tabla con registros -->
     <?php $bodyOutput ?>
    <!--<table>
        <thead>
            <tr>
                <th>Seleccionar</th>
                
                <th>Nombre</th>
                <th>Edad</th>
                <th>Curso</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" name="registro" value="1"></td>
                
                <td>Juan</td>
                <td>20</td>
                <td>PHP Avanzado</td>
                <td><a href="#" onclick="alert('Visualizar registro 1')">Ver</a></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="registro" value="2"></td>
                
                <td>Ana</td>
                <td>22</td>
                <td>HTML y CSS</td>
                <td><a href="#" onclick="alert('Visualizar registro 2')">Ver</a></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="registro" value="3"></td>
                
                <td>Pablo</td>
                <td>21</td>
                <td>JavaScript</td>
                <td><a href="#" onclick="alert('Visualizar registro 3')">Ver</a></td>
            </tr>
        </tbody>
    </table>-->
</body>
</html>

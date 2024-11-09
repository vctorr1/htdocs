<?php
session_start();

// Array de productos (simulando una base de datos)
$productos = [
    1 => ['id' => 1, 'nombre' => 'Producto 1', 'precio' => 10.99],
    2 => ['id' => 2, 'nombre' => 'Producto 2', 'precio' => 20.99],
    3 => ['id' => 3, 'nombre' => 'Producto 3', 'precio' => 15.99]
];

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Procesar acciones del carrito
if (isset($_POST['accion'])) {
    $id = $_POST['id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

    switch ($_POST['accion']) {
        case 'agregar':
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] += $cantidad;
            } else {
                $_SESSION['carrito'][$id] = $cantidad;
            }
            break;
            
        case 'actualizar':
            if ($cantidad <= 0) {
                unset($_SESSION['carrito'][$id]);
            } else {
                $_SESSION['carrito'][$id] = $cantidad;
            }
            break;
    }
    
    header('Location: ' . ($_POST['accion'] === 'agregar' ? 'index.php' : 'carrito.php'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Simple</title>
    <style>
        .producto {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            width: 200px;
        }
        .controles {
            margin: 10px 0;
        }
        button {
            padding: 5px 10px;
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <h1>Productos Disponibles</h1>
    
    <?php foreach ($productos as $producto): ?>
        <div class="producto">
            <h3><?php echo $producto['nombre']; ?></h3>
            <p>Precio: €<?php echo $producto['precio']; ?></p>
            
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                <input type="hidden" name="accion" value="agregar">
                
                <div class="controles">
                    <button type="button" onclick="restar(this)">-</button>
                    <input type="number" name="cantidad" value="1" min="1" style="width: 50px">
                    <button type="button" onclick="sumar(this)">+</button>
                </div>
                
                <button type="submit">Añadir al carrito</button>
            </form>
        </div>
    <?php endforeach; ?>

    <p>
        <button onclick="window.location.href='carrito.php'">Ver carrito</button>
    </p>

    <script>
        function sumar(btn) {
            let input = btn.parentNode.querySelector('input');
            input.value = parseInt(input.value) + 1;
        }

        function restar(btn) {
            let input = btn.parentNode.querySelector('input');
            let valor = parseInt(input.value) - 1;
            if (valor >= 1) input.value = valor;
        }
    </script>
</body>
</html>
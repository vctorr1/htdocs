<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple-v1.css">
</head>
<body>
    <h1>Productos disponibles</h1>
    
    <?php echo $bodyOutput; //lista de productos ?>

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

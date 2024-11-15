<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple-v1.css">
</head>

<body>
    <h1>Productos en el carrito</h1>

    <?php echo $bodyOutput; //productos en el carrito 
    ?>

    <p>
        <button onclick="window.location.href='index.php'">Seguir comprando</button>
    </p>

    <!-- botones con js-->
    <script>
        function sumar(btn) {
            let input = btn.parentNode.querySelector('input');
            input.value = parseInt(input.value) + 1;
            btn.closest('form').submit();
        }

        function restar(btn) {
            let input = btn.parentNode.querySelector('input');
            let valor = parseInt(input.value) - 1;
            if (valor >= 0) {
                input.value = valor;
                btn.closest('form').submit(); //el formulario se envía solo si se resta por debajo de 1
            }
        }
    </script>
</body>

</html>
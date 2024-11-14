<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple-v1.css">
</head>

<body>
    <h1>Productos en el carrito</h1>

    <?php echo $bodyOutput; // Aquí se imprime el contenido del carrito generado por printCarritoHTML 
    ?>

    <p>
        <button onclick="window.location.href='index.php'">Seguir comprando</button>
    </p>

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
                btn.closest('form').submit(); // Enviar formulario automáticamente al restar
            }
        }
    </script>
</body>

</html>
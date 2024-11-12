<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple-v1.css">
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
<?php
session_start();

require_once'productos.php';

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compra</title>
    <style>
        .item {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
        }

        .controles {
            margin: 10px 0;
        }

        .total {
            font-weight: bold;
            font-size: 1.2em;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <h1>Tu Carrito</h1>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>El carrito está vacío</p>
    <?php else: ?>
        <?php
        $total = 0;
        foreach ($_SESSION['carrito'] as $id => $cantidad):
            if (isset($productos[$id])):
                $total += $productos[$id]['precio'] * $cantidad;
        ?>
                <div class="item">
                    <h3><?php echo $productos[$id]['nombre']; ?></h3>
                    <p>Precio: €<?php echo $productos[$id]['precio']; ?></p>

                    <form method="post" action="index.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="accion" value="actualizar">

                        <div class="controles">
                            <button type="button" onclick="restar(this)">-</button>
                            <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" min="0" style="width: 50px">
                            <button type="button" onclick="sumar(this)">+</button>
                            <button type="submit">Actualizar</button>
                        </div>
                    </form>

                    <p>Subtotal: €<?php echo number_format($productos[$id]['precio'] * $cantidad, 2); ?></p>
                </div>
        <?php
            endif;
        endforeach;
        ?>

        <div class="total">
            Total: €<?php echo number_format($total, 2); ?>
        </div>
    <?php endif; ?>

    <p>
        <button onclick="window.location.href='index.php'">Seguir comprando</button>
    </p>

    <script>
        function sumar(btn) {
            let input = btn.parentNode.querySelector('input');
            input.value = parseInt(input.value) + 1;
        }

        function restar(btn) {
            let input = btn.parentNode.querySelector('input');
            let valor = parseInt(input.value) - 1;
            if (valor >= 0) {
                input.value = valor;
                // Si estamos en el carrito y la cantidad es 0, enviamos el formulario
                if (valor === 0 && window.location.pathname.includes('carrito.php')) {
                    btn.closest('form').submit();
                }
            }
        }
    </script>
</body>

</html>
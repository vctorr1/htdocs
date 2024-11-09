<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>

<body>
    <h1>Carrito</h1>

    <?php
    echo $html;
    echo $arrayOutput;

    ?>

    <form name="carrito-form">
        <table>
            <tr>
                <td>Imagen Prod</td>
                <td>Producto</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Acciones</td>
            </tr>
            <tbody>
                <tr>
                <td><img src="https://www.recetasnestlecam.com/sites/default/files/styles/crop_article_banner_desktop_nes/public/2022-04/Main-Banner-Desktop-1200x384.webp?itok=0GbkJ_6k" width="50" height="auto" alt="manzana"></td>
                <td>Manzana</td>
                <td>39.99€</td>
                <td>1</td>
                <td><input type="button" value="-" name="-"><input type="button" value="+" name="+"></td>
                </tr>
                <tr>
                <td><img src="https://www.recetasnestlecam.com/sites/default/files/styles/crop_article_banner_desktop_nes/public/2022-04/Main-Banner-Desktop-1200x384.webp?itok=0GbkJ_6k" width="50" height="auto" alt="manzana"></td>
                <td>Manzana</td>
                <td>39.99€</td>
                <td>1</td>
                <td><input type="button" value="-" name="-"><input type="button" value="+" name="+"></td>
                </tr>
                <tr>
                <td><img src="https://www.recetasnestlecam.com/sites/default/files/styles/crop_article_banner_desktop_nes/public/2022-04/Main-Banner-Desktop-1200x384.webp?itok=0GbkJ_6k" width="50" height="auto" alt="manzana"></td>
                <td>Manzana</td>
                <td>39.99€</td>
                <td>1</td>
                <td><input type="button" value="-" name="-"><input type="button" value="+" name="+"></td>
                </tr>
            </tbody>
        </table>
    </form>
</body>

</html>
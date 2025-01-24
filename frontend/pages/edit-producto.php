<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit-producto</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <?php
    require_once(__DIR__ . "/../../backend/model/Producto.php");
    require_once(__DIR__ . "/../../backend/service/ProductoService.php");
    ?>
</head>

<body>

    <div class="titulo">
        <h1>Editar stock</h1>
        <li><a href="/frontend/display.php">Volver</a></li>
    </div>
    <div class="datos">
        <div>
        <table>
            <thead>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock de gramos</th>
            </thead>
            <tbody>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                    $producto = getProductById($_POST['product_id']);
                ?>
                <tr>
                    <td><?= $producto->getNombre() ?></td>
                    <td><?= $producto->getPrecio() ?></td>
                    <td><?= $producto->getStockGramos() ?></td>
                </tr>

            </tbody>
        </table>
        <form method="POST">
                <label for="stock_gramos">Stock nuevo:</label>
                <input type="hidden" name='product_id' value=<?= $producto->getIdProducto() ?>>
                <input type="number" name="stock_gramos" required>
                <input type="submit" name="cambiarStock" value="Aceptar">
            </form>
        </div>
        
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiarStock'])) {


        updateStockProducto($_POST['product_id'], $_POST['stock_gramos']);

        header('Location: ../display.php');
        exit();
    }
    ?>
</body>

</html>
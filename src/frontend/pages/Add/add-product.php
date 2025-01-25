<?php
require_once(__DIR__."/../../../backend/service/ProductoService.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $stockGramos = intval($_POST['stock_gramos']);

    $data = ['nombre'=> $nombre,'precio'=> $precio, 'stockGramos' => $stockGramos];
    createProducto($data);
    header('Location: ../../display.php');

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../../assets/styles.css">
</head>
<body>
    <h1>Add Product</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" required>
        <br>
        <label for="stock_gramos">Stock Gramos:</label>
        <input type="number" name="stock_gramos" required>
        <br>
        <input value="Añadir producto" type="submit"></input>
    </form>
    <li><a href="../../display.php">Volver</a></li>
</body>
</html>

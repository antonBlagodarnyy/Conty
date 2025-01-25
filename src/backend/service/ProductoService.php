<?php
require_once(__DIR__ . "/../model/Producto.php");
require_once(__DIR__. '/../controllers/ProductoController.php');

function getAllProducts(): array
{
    $products = [];
    $data = ProductoController::getAll();
    foreach ($data as $key => $producto) {
        array_push($products, new Producto($producto['idProducto'], $producto['nombre'], $producto['precio'], $producto['stockGramos']));
    }
    return $products;
}

function getProductById(int $idProduct): object
{
    $data = ProductoController::getById($idProduct);
    return new Producto($data['idProducto'], $data['nombre'], $data['precio'], $data['stockGramos']);
}

function deleteProducto(int $idProduct): void
{
    ProductoController::delete($idProduct);
}

function createProducto(array $data): void
{
    ProductoController::create($data);
}

function updateStockProducto(int $idProduct, $stock)
{
    ProductoController::updateStock($idProduct, $stock);
}

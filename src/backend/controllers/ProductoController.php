<?php
require_once (__DIR__."/../config/database.php"); // Database connection file

class ProductoController
{
    public static function getAll()
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM Producto";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getById($id)
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM Producto WHERE idProducto = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data)
    {
        $db = Database::getConnection();
        $query = "INSERT INTO Producto (nombre, precio, stockGramos) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sdi', $data['nombre'], $data['precio'], $data['stockGramos']);
        return $stmt->execute();
    }

    public static function update($id, $data)
    {
        $db = Database::getConnection();
        $query = "UPDATE Producto SET nombre = ?, precio = ?, gramosPorCliente = ?, stockGramos = ? WHERE idProducto = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sdiiii', $data['nombre'], $data['precio'], $data['stockGramos'], $data['disponible'], $id);
        return $stmt->execute();
    }

    public static function updateStock($id, $stock)
    {
        $db = Database::getConnection();
        $query = "UPDATE Producto SET stockGramos = ? WHERE idProducto = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ii', $stock, $id);
        return $stmt->execute();
    }

    public static function delete($id)
    {
        $db = Database::getConnection();
        $query = "DELETE FROM Producto WHERE idProducto = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}

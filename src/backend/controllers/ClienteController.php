<?php
require_once (__DIR__."/../config/database.php"); // Database connection file

class ClienteController
{
    // Fetch all clientes
    public static function getAll()
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM Cliente";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch a cliente by ID
    public static function getById($id)
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM Cliente WHERE idCliente = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create a new cliente
    public static function create($data)
    {
        $db = Database::getConnection();
        $query = "INSERT INTO Cliente (nombre, telefono) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $data['nombre'], $data['telefono']);
        return $stmt->execute();
    }

    // Update an existing cliente
    public static function update($id, $data)
    {
        $db = Database::getConnection();
        $query = "UPDATE Cliente SET nombre = ?, telefono = ? WHERE idCliente = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssi', $data['nombre'], $data['telefono'], $id);
        return $stmt->execute();
    }

    // Delete a cliente
    public static function delete($id)
    {
        $db = Database::getConnection();
        $query = "DELETE FROM Cliente WHERE idCliente = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}

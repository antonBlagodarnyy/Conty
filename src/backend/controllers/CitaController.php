<?php
require_once (__DIR__."/../config/database.php"); // Database connection file

class CitaController
{

    // GET all citas
    public static function getAllCitas()
    {
        $db = Database::getConnection();
        $query = "SELECT * 
FROM Cita 
LEFT JOIN CitaProducto ON Cita.idCita = CitaProducto.idCitaR
LEFT JOIN Producto ON CitaProducto.idProductoR = Producto.idProducto;
";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // GET single cita by ID
    public static function getPlainCitaById($id)
    {
        $query = "SELECT * FROM Cita WHERE idCita = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // POST new cita
    public static function createPlainCita($data): int
    {
        $query = "INSERT INTO Cita (fecha, idCliente, costes, cobro) VALUES (?, ?, ?, ?)";
        $stmt = Database::getConnection()->prepare($query);

        $fecha = $data['fecha'];
        $idCliente = $data['clienteId'];
        $costes = $data['costes'];
        $cobro = $data['cobro'];

        $stmt->bind_param("siid", $fecha, $idCliente, $costes, $cobro);

        $stmt->execute();

        return $stmt->insert_id;
    }
    public static function addProducts($idProducto, $cita,$cantidad)
    {
        $query = "INSERT INTO CitaProducto (idCitaR, idProductoR,cantidad) VALUES (?, ?, ?)";
        $stmt = Database::getConnection()->prepare($query);

        $idCita = $cita['idCita'];

        $stmt->bind_param("iii", $idCita, $idProducto,$cantidad);

        if ($stmt->execute()) {
            return json_encode(['message' => 'Cita created successfully']);
        } else {
            return json_encode(['error' => 'Failed to create cita']);
        }
    }

    // PUT (update) cita by ID
    public function updateCita($id, $data)
    {
        $query = "UPDATE Cita SET fecha = ?, idCliente = ?, costes = ?, cobro = ? WHERE idCita = ?";
        $stmt = Database::getConnection()->prepare($query);

        $fecha = $data['fecha'];
        $idCliente = $data['idCliente'];
        $costes = $data['costes'];
        $cobro = $data['cobro'];

        $stmt->bind_param("siidi", $fecha, $idCliente, $costes, $cobro, $id);

        if ($stmt->execute()) {
            return json_encode(['message' => 'Cita updated successfully']);
        } else {
            return json_encode(['error' => 'Failed to update cita']);
        }
    }

    // DELETE cita by ID
    public static function delete($id)
    {
        $query = "DELETE FROM Cita WHERE idCita = ?";
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return json_encode(['message' => 'Cita deleted successfully']);
        } else {
            return json_encode(['error' => 'Failed to delete cita']);
        }
    }

 
}

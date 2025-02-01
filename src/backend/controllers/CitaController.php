<?php
require_once(__DIR__ . "/../config/database.php"); // Database connection file
require_once(__DIR__ . "/../service/ProductoService.php");
class CitaController
{

    // GET all citas
    public static function getAllCitas()
    {
        $db = Database::getConnection();
        $query = "SELECT * 
FROM Cita 
LEFT JOIN CitaProducto ON Cita.idCita = CitaProducto.idCitaR;";
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
        $query = "INSERT INTO Cita (fecha, nombreCliente, trabajo, costes, cobro) VALUES (?, ?, ?, ?, ?)";
        $stmt = Database::getConnection()->prepare($query);

        $trabajo = $data['trabajo'];
        $fecha = $data['fecha'];
        $clienteNombre = $data['clienteNombre'];
        $costes = $data['costes'];
        $cobro = $data['cobro'];

        $stmt->bind_param("sssdd", $fecha, $clienteNombre, $trabajo, $costes, $cobro);

        $stmt->execute();

        return $stmt->insert_id;
    }
    public static function addProducts($idProducto, $cita, $cantidad)
    {
        $query = "INSERT INTO CitaProducto (idCitaR, citaProductoNombre,cantidad) VALUES (?, ?, ?)";


        $idCita = $cita['idCita'];
        $productoNombre = getProductById($idProducto)->getNombre();
        $stmt = Database::getConnection()->prepare($query);
        $stmt->bind_param("isd", $idCita, $productoNombre, $cantidad);

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

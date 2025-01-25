<?php
require_once(__DIR__ . "/../service/ProductoService.php");
require_once(__DIR__ . "/../service/ClienteService.php");
require_once(__DIR__ . '/../controllers/CitaController.php');


function getAllCitasObj()
{
    // Fetch raw data from the database
    $data = CitaController::getAllCitas();

    // Create an associative array to group Citas by idCita
    $citas = [];

    // Iterate through the fetched data
    foreach ($data as $row) {
        $idCita = $row['idCita'];

        // If this Cita is not already created, initialize it
        if (!isset($citas[$idCita])) {
            $citas[$idCita] = new Cita(
                $idCita,
                date_create_from_format('Y-m-d H:i:s', $row['fecha']),
                getClientById($row['idCliente']),
                [], // Initialize with an empty array of productos
                (float)$row['costes'],
                (float)$row['cobro']
            );
        }
        if (!is_null($row['idProducto'])) {
            // Create a Producto object for each product in the row
            $producto = new Producto($row['idProducto'], $row['nombre'], (float)$row['precio'], (int)$row['stockGramos']);
            $cantidad = $row['cantidad'];

            // Add the Producto to the Cita's productos array using a method
            $citas[$idCita]->addProducto($producto, $cantidad);
        }
    }

    // Return the Citas as a numerically indexed array
    return $citas;
}



function crearCita($data): void
{
    $allAvailable = true;
    foreach ($data['productos'] as $key => $producto) {

        if (getProductById($producto['idProducto'])->getStockGramos() < $producto['cantidad'])
            $allAvailable = false;
    }
    if ($allAvailable) {
        $idCita =  CitaController::createPlainCita($data);
        $citaData = CitaController::getPlainCitaById($idCita);

        if (count($data['productos']) > 0) {
            foreach ($data['productos'] as $key => $producto) {

                updateStockProducto($producto['idProducto'], getProductById($producto['idProducto'])->getStockGramos() - $producto['cantidad']);
                CitaController::addProducts($producto['idProducto'], $citaData, $producto['cantidad']);
            }
        }
    }
}

function deleteCita($idCita)
{
    CitaController::delete($idCita);

}

function getBeneficiosTotales(array $citas): float
{
    $beneficiosTotales = 0;
    foreach ($citas as $cita) {
        $beneficiosTotales += $cita->getBeneficios();
    }
    return $beneficiosTotales;
}

function getCostesTotales(array $citas): float
{
    $costesTotales = 0;
    foreach ($citas as $cita) {
        $costesTotales += $cita->getCostes();
    }
    return $costesTotales;
}

function getCobrosTotales(array $citas): float
{
    $cobrosTotales = 0;
    foreach ($citas as $cita) {
        $cobrosTotales += $cita->getCobro();
    }
    return $cobrosTotales;
}

function filtrarCitasPorAnio(string $anio, array $citas): array//TODO implementarlo
{
    $comprobarAnio = function ($cita) use ($anio) {
        $numeroAnioCita = $cita->getFecha()->format('y'); // Get the numeric month (01-12)

        // Check if either the month name or number matches
        return $numeroAnioCita === $anio;
    };

    return  array_filter($citas, $comprobarAnio);
}


function filtrarCitasPorMes(string $mes, array $citas): array
{

    $comprobarMes = function ($cita) use ($mes) {
        $numeroMesCita = $cita->getFecha()->format('m'); // Get the numeric month (01-12)

        // Check if either the month name or number matches
        return $numeroMesCita === $mes;
    };

    return  array_filter($citas, $comprobarMes);
}

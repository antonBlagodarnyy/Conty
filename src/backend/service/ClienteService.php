<?php
require_once(__DIR__ . "/../model/Cliente.php");
require_once(__DIR__. '/../controllers/ClienteController.php');


function getAllClients() : array{
    $clientes = [];
    $data = ClienteController::getAll();
    foreach ($data as $key => $cliente) {
        array_push($clientes,new Cliente($cliente['idCliente'],$cliente['nombre'],$cliente['telefono']));
    }
    return $clientes;
}

function getClientById(int $idCliente) : object{
    $data = ClienteController::getById($idCliente);
    return new Cliente ($data['idCliente'],$data['nombre'],$data['telefono']);
}

function deleteCliente(int $idCliente):void{
    ClienteController::delete($idCliente);
}

function createCliente(array $data):void{
    ClienteController::create($data);
}

function ordenarCliente(array $cliente): array
{
    function compareNombres($cliente1, $cliente2)
    {
        return $cliente1->getNombre() > $cliente2->getNombre();
    }
    usort($cliente, "compareNombres");
    return $cliente;
}


?>
<?php
require_once("Producto.php");

class Cliente {
    private $idCliente;
    private $nombre;
    private $telefono;

    function __construct(int $idCliente,String $nombre, String $telefono)
    {
        $this->idCliente = $idCliente; 
        $this->nombre = $nombre;
        $this->telefono = $telefono;
    }

    // Getters
    public function getIdCliente(): String
    {
        return $this->idCliente;
    }

    public function getNombre(): String
    {
        return $this->nombre;
    }

    public function getTelefono(): String
    {
        return $this->telefono;
    }

    // Setters
    public function setIdCliente(String $idCliente): void
    {
        $this->idCliente = $idCliente;
    }

    public function setNombre(String $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setTelefono(String $telefono): void
    {
        $this->telefono = $telefono;
    }
    
    // toString method
    public function __toString(): String
    {
        return "Cliente [idCliente: {$this->idCliente}, Nombre: {$this->nombre}, Telefono: {$this->telefono}]";
    }
}

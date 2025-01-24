<?php
class Producto
{
    private $idProducto;
    private $nombre;
    private $precio;

    private $stockGramos;
    private $disponible;

    function __construct(int $idProducto, String $nombre, float $precio, int $stockGramos)
    {
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->precio = $precio;

        $this->stockGramos = $stockGramos;
    }

    // Getters
    public function getIdProducto(): String
    {
        return $this->idProducto;
    }

    public function getNombre(): String
    {
        return $this->nombre;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }



    public function getStockGramos(): int
    {
        return $this->stockGramos;
    }



    // Setters
    public function setIdProducto(String $idProducto): void
    {
        $this->idProducto = $idProducto;
    }

    public function setNombre(String $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }



    public function setStockGramos(int $stockGramos): void
    {
        $this->stockGramos = $stockGramos;
    }


    public function getFaltaStock(): bool
    {
        return $this->stockGramos <= 10;
    }
    // toString method
    public function __toString(): String
    {
        return "Producto [idProducto: {$this->idProducto}, Nombre: {$this->nombre}, Precio: {$this->precio}, StockGramos: {$this->stockGramos}, Disponible: " . ($this->disponible ? "Sí" : "No") . "]";
    }
}

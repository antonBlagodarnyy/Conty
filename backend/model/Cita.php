<?php
class Cita
{
    private $idCita;
    private $fecha;
    private $cliente;
    private $productos = [];
    private $costes;
    private $cobro;

    function __construct(int $idCita, DateTime $fecha, $cliente, array $productos, float $costes, float $cobro)
    {
        $this->idCita = $idCita; // ID único para la cita
        $this->fecha = $fecha;
        $this->cliente = $cliente;

        $this->costes = $costes;
        $this->cobro = $cobro;


        $this->productos = $productos;
    }

    // Getters
    public function getIdCita(): String
    {
        return $this->idCita;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function getProductos(): array
    {
        return $this->productos;
    }

    public function getCostes(): float
    {
        return $this->costes;
    }

    public function getCobro(): float
    {
        return $this->cobro;
    }

    public function getBeneficios(): float
    {
        return $this->cobro - $this->costes;
    }

    // Setters
    public function setIdCita(String $idCita): void
    {
        $this->idCita = $idCita;
    }

    public function setFecha(String $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function setCliente($cliente): void
    {
        $this->cliente = $cliente;
    }

    public function setProducto(array $productos): void
    {
        $this->productos = $productos;
    }
    public function addProducto($producto, $cantidad): void
    {
        $this->productos[] = [
            'producto' => $producto,
            'cantidad' => $cantidad
        ];
    }

    public function setCostes(float $costes): void
    {
        $this->costes = $costes;
    }

    public function setCobro(float $cobro): void
    {
        $this->cobro = $cobro;
    }



    // toString method
    public function __toString(): String
    {
        $productosStr = '';
        foreach ($this->productos as $key => $producto) {
            $productosStr .= $producto->getNombre() . ' ';
        }


        return "Cita [idCita: {$this->idCita}, Fecha: {$this->fecha}, Cliente: {$this->cliente->getNombre()}, Productos: [{$productosStr}], Costes: {$this->costes}, Cobro: {$this->cobro}, Beneficios: {$this->getBeneficios()}]";
    }
}

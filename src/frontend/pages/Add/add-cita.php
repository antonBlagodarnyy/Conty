<?php
require_once(__DIR__ . "/../../../backend/service/ClienteService.php");
require_once(__DIR__ . "/../../../backend/service/ProductoService.php");
require_once(__DIR__ . "/../../../backend/service/CitasService.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $clienteNombre = $_POST['cliente'];

    // Extract selected product IDs and their quantities
    $productosSeleccionados = isset($_POST['productos']) ? $_POST['productos'] : [];
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];

    $productosFinal = [];

    foreach ($productosSeleccionados as $productoId) {
        // Ensure a quantity exists for the selected product
        if (isset($cantidades[$productoId])) {
            $productosFinal[] = [
                'idProducto' => intval($productoId),
                'cantidad' => intval($cantidades[$productoId])
            ];
        }
    }

    $trabajo = $_POST['trabajo'];
    $fecha = $_POST['fecha'];
    $costes = floatval($_POST['costes']);
    $cobro = floatval($_POST['cobro']);

    $data = [
        'clienteNombre' => $clienteNombre,
        'productos' => $productosFinal, // 2D array of product IDs and quantities
        'trabajo' => $trabajo,
        'fecha' => $fecha,
        'costes' => $costes,
        'cobro' => $cobro
    ];

    $cita = crearCita($data);

    header('Location: ../../display.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cita</title>
    <link rel="stylesheet" href="../../assets/styles.css">
    <script>
        function toggleRequired(idProducto) {
            const selectField = document.getElementById(`producto${idProducto}`);
            const dependentField = document.getElementById(`cantidadProducto${idProducto}`);

            if (selectField.checked) { // Adjust the value as needed
                dependentField.required = true;
                dependentField.disabled = false;
            } else {
                dependentField.required = false;
                dependentField.disabled = true;
                dependentField.value = ''; // Clear the field when disabled
            }
        }
    </script>
</head>

<body>

    <h1>Add Cita</h1>
    <form method="POST">
        <label for="cliente">Cliente:</label>
        <select name="cliente" required>
            <?php
            $clientes = getAllClients();
            foreach ($clientes as $index => $cliente): ?>
                <option value="<?= htmlspecialchars($cliente->getNombre()) ?>"><?= htmlspecialchars($cliente->getNombre()) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="productos">Productos:</label>

        <?php
        $productos = getAllProducts();
        foreach ($productos as $producto): ?>
            <div>
                <input type="checkbox" name="productos[<?= $producto->getIdProducto() ?>]" value="<?= $producto->getIdProducto() ?>" id="producto<?= $producto->getIdProducto() ?>" onchange="toggleRequired(<?= $producto->getIdProducto() ?>)">
                <label for="producto<?= $producto->getIdProducto() ?>"><?= $producto->getNombre() ?></label>

                <label for="cantidadProducto<?= $producto->getIdProducto() ?>">Cantidad:</label>
                <input type="number" name="cantidades[<?= $producto->getIdProducto() ?>]" max="<?= $producto->getStockGramos() ?>" id="cantidadProducto<?= $producto->getIdProducto() ?>" disabled>
            </div>
        <?php endforeach; ?>

        <label for="trabajo">Trabajo:</label>
        <input type="text" name="trabajo" required>

        <label for="fecha">Fecha:</label>
        <input type="datetime-local" name="fecha" required>

        <label for="costes">Costes:</label>
        <input type="number" step="0.01" name="costes">

        <label for="cobro">Cobro:</label>
        <input type="number" step="0.01" name="cobro" required>

        <input value="Añadir cita" type="submit"></input>
    </form>
    <li><a href="../../display.php">Volver</a></li>
</body>

</html>
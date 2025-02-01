<?php
require_once(__DIR__ . "/../backend/model/Cliente.php");
require_once(__DIR__ . "/../backend/service/ClienteService.php");
require_once(__DIR__ . "/../backend/model/Producto.php");
require_once(__DIR__ . "/../backend/service/ProductoService.php");
require_once(__DIR__ . "/../backend/model/Cita.php");
require_once(__DIR__ . "/../backend/service/CitasService.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCliente'])) {
    deleteCliente($_POST['client_id']);
    header("Refresh:0");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteProducto'])) {
    deleteProducto($_POST['product_id']);
    header("Refresh:0");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCita'])) {
    deleteCita($_POST['cita_id']);
    header("Refresh:0");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <link rel="stylesheet" href="./assets/styles.css">

</head>

<body>
    <h1>Visualizador de datos</h1>
    <div>
        <h2>Filtrar citas por mes</h2>
        <nav>
            <ul>
                <li><a href="/">Anual</a></li>
                <li><a href="pages/Meses/Enero.php">Enero</a></li>
                <li><a href="pages/Meses/Febrero.php">Febrero</a></li>
                <li><a href="pages/Meses/Marzo.php">Marzo</a></li>
                <li><a href="pages/Meses/Abril.php">Abril</a></li>
                <li><a href="pages/Meses/Mayo.php">Mayo</a></li>
                <li><a href="pages/Meses/Junio.php">Junio</a></li>
                <li><a href="pages/Meses/Julio.php">Julio</a></li>
                <li><a href="pages/Meses/Agosto.php">Agosto</a></li>
                <li><a href="pages/Meses/Septiembre.php">Septiembre</a></li>
                <li><a href="pages/Meses/Octubre.php">Octubre</a></li>
                <li><a href="pages/Meses/Noviembre.php">Noviembre</a></li>
                <li><a href="pages/Meses/Diciembre.php">Diciembre</a></li>

            </ul>
        </nav>
    </div>
    <div class="datos">
        <div>
            <div class=titulo>
                <h2>Clientes</h2>
                <li><a href="pages/Add/add-client.php">Añadir cliente</a></li>
            </div>
            <table>
                <thead>
                    <th>Nombre</th>
                    <th>Telefono</th>
                </thead>
                <tbody>
                    <?php $clientes = getAllClients();
                    $clientes = ordenarCliente($clientes);
                    foreach ($clientes as $key => $cliente): ?>
                        <tr>
                            <td><?= $cliente->getNombre() ?></td>
                            <td><?= $cliente->getTelefono() ?></td>
                            <td>
                                <form method='POST'>
                                    <input type="hidden" name="client_id" value="<?= htmlspecialchars($cliente->getIdCliente()) ?>">
                                    <button type='submit' name='deleteCliente' value='Eliminar' onclick="return confirm('¿Seguro desea elimnar a este cliente?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <div class="titulo">
                <h2>Productos</h2>
                <li><a href="pages/Add/add-product.php">Añadir producto</a></li>
            </div>
            <table>
                <thead>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock de gramos</th>
                </thead>
                <tbody>
                    <?php $productos = getAllProducts();
                    $productos = ordenarProducto($productos);
                    foreach ($productos as $key => $producto): ?>
                        <tr>
                            <td><?= $producto->getNombre() ?></td>
                            <td><?= $producto->getPrecio() ?></td>
                            <?php if ($producto->getFaltaStock()): ?>
                                <td style="color:red">
                                <?php else: ?>
                                <td>
                                <?php endif; ?>
                                <?= $producto->getStockGramos() ?>
                                </td>
                                <td>
                                    <form method='POST'>
                                        <input type="hidden" name="product_id" value="<?= $producto->getIdProducto() ?>">
                                        <button type='submit' name='deleteProducto' value='Eliminar' onclick="return confirm('¿Seguro desea elimnar a este producto?')">Eliminar</button>
                                    </form>
                                    <form method='POST' action="/frontend/pages/edit-producto.php">
                                        <input type="hidden" name="product_id" value="<?= $producto->getIdProducto() ?>">

                                        <input type='submit' name='editProducto' value='Editar stock'>
                                    </form>
                                </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <div class="titulo">
                <h2>Citas</h2>
                <li><a href="pages/Add/add-cita.php">Añadir cita</a></li>
            </div>
            <table>
                <thead>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Trabajo</th>
                    <th>Productos</th>
                    <th>Costes</th>
                    <th>Cobro</th>
                    <th>Beneficios</th>
                </thead>
                <tbody>

                    <?php
                    $citas = getAllCitasObj();
                    $citas =  ordenarCitas($citas);
                    foreach ($citas as $cita):
                    ?>
                        <tr>
                            <td><?= date_format($cita->getFecha(), "Y/m/d") ?></td>
                            <td><?= $cita->getCliente() ?></td>
                            <td><?= $cita->getTrabajo() ?></td>
                            <td>
                                <?php if (count($cita->getProductos()) > 0): ?>
                                    <table>
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cita->getProductos() as $key => $producto): ?>
                                                <tr>
                                                    <td><?= $producto['producto'] ?></td>
                                                    <td><?= $producto['cantidad'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                    </table>
                                <?php endif; ?>
                            </td>
                            <td><?= $cita->getCostes() ?></td>
                            <td><?= $cita->getCobro() ?></td>
                            <td><?= $cita->getBeneficios() ?></td>
                            <td>
                                <form method='POST'>
                                    <input type="hidden" name="cita_id" value="<?= htmlspecialchars($cita->getIdCita()) ?>">
                                    <button type='submit' name='deleteCita' value='Eliminar' onclick="return confirm('¿Seguro desea elimnar a esta cita?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <?php
            $citasEnero = filtrarCitasPorMes("01", $citas);
            $citasFebrero = filtrarCitasPorMes("02", $citas);
            $citasMarzo = filtrarCitasPorMes("03", $citas);
            $citasAbril = filtrarCitasPorMes("04", $citas);
            $citasMayo = filtrarCitasPorMes("05", $citas);
            $citasJunio = filtrarCitasPorMes("06", $citas);
            $citasJulio = filtrarCitasPorMes("07", $citas);
            $citasAgosto = filtrarCitasPorMes("08", $citas);
            $citasSeptiembre = filtrarCitasPorMes("09", $citas);
            $citasOctubre = filtrarCitasPorMes("10", $citas);
            $citasNoviembre = filtrarCitasPorMes("11", $citas);
            $citasDiciembre = filtrarCitasPorMes("12", $citas);
            ?>
            <div class="titulo">
                <h2>Cuentas:</h2>
            </div>
            <table>
                <thead>
                    <th>Tipo</th>

                    <th>Enero</th>
                    <th>Febrero</th>
                    <th>Marzo</th>
                    <th>Abril</th>
                    <th>Mayo</th>
                    <th>Junio</th>
                    <th>Julio</th>
                    <th>Agosto</th>
                    <th>Septiembre</th>
                    <th>Octubre</th>
                    <th>Noviembre</th>
                    <th>Diciembre</th>
                    <th>Totales</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Costes</td>

                        <td><?= getCostesTotales($citasEnero) ?></td>
                        <td><?= getCostesTotales($citasFebrero) ?></td>
                        <td><?= getCostesTotales($citasMarzo) ?></td>
                        <td><?= getCostesTotales($citasAbril) ?></td>
                        <td><?= getCostesTotales($citasMayo) ?></td>
                        <td><?= getCostesTotales($citasJunio) ?></td>
                        <td><?= getCostesTotales($citasJulio) ?></td>
                        <td><?= getCostesTotales($citasAgosto) ?></td>
                        <td><?= getCostesTotales($citasSeptiembre) ?></td>
                        <td><?= getCostesTotales($citasOctubre) ?></td>
                        <td><?= getCostesTotales($citasNoviembre) ?></td>
                        <td><?= getCostesTotales($citasDiciembre) ?></td>
                        <td><?= getCostesTotales($citas) ?></td>
                    </tr>
                    <tr>
                        <td>Cobros</td>

                        <td><?= getCobrosTotales($citasEnero) ?></td>
                        <td><?= getCobrosTotales($citasFebrero) ?></td>
                        <td><?= getCobrosTotales($citasMarzo) ?></td>
                        <td><?= getCobrosTotales($citasAbril) ?></td>
                        <td><?= getCobrosTotales($citasMayo) ?></td>
                        <td><?= getCobrosTotales($citasJunio) ?></td>
                        <td><?= getCobrosTotales($citasJulio) ?></td>
                        <td><?= getCobrosTotales($citasAgosto) ?></td>
                        <td><?= getCobrosTotales($citasSeptiembre) ?></td>
                        <td><?= getCobrosTotales($citasOctubre) ?></td>
                        <td><?= getCobrosTotales($citasNoviembre) ?></td>
                        <td><?= getCobrosTotales($citasDiciembre) ?></td>
                        <td><?= getCobrosTotales($citas) ?></td>
                    </tr>
                    <tr>
                        <td>Beneficios</td>

                        <td><?= getBeneficiosTotales($citasEnero) ?></td>
                        <td><?= getBeneficiosTotales($citasFebrero) ?></td>
                        <td><?= getBeneficiosTotales($citasMarzo) ?></td>
                        <td><?= getBeneficiosTotales($citasAbril) ?></td>
                        <td><?= getBeneficiosTotales($citasMayo) ?></td>
                        <td><?= getBeneficiosTotales($citasJunio) ?></td>
                        <td><?= getBeneficiosTotales($citasJulio) ?></td>
                        <td><?= getBeneficiosTotales($citasAgosto) ?></td>
                        <td><?= getBeneficiosTotales($citasSeptiembre) ?></td>
                        <td><?= getBeneficiosTotales($citasOctubre) ?></td>
                        <td><?= getBeneficiosTotales($citasNoviembre) ?></td>
                        <td><?= getBeneficiosTotales($citasDiciembre) ?></td>
                        <td><?= getBeneficiosTotales($citas) ?></td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>


</body>


</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enero</title>
    <link rel="stylesheet" href="../../assets/styles.css">
    <?php
    require_once(__DIR__ ."/../../../backend/model/Cliente.php");
    require_once(__DIR__ ."/../../../backend/service/ClienteService.php");

    require_once(__DIR__ ."/../../../backend/model/Producto.php");
    require_once(__DIR__ ."/../../../backend/service/ProductoService.php");

    require_once(__DIR__ ."/../../../backend/model/Cita.php");
    require_once(__DIR__ ."/../../../backend/service/CitasService.php");
    ?>
</head>
<body>
    
        <div class="titulo">
        <h3>Citas del mes de Septiembre</h3>
        <li><a href="../../display.php">Volver</a></li>
        </div>
        <div class="datos">
        <table>
                <thead>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Productos</th>
                    <th>Costes</th>
                    <th>Cobro</th>
                    <th>Beneficios</th>
                </thead>
                <tbody>

                    <?php
                    $citasAll = getAllCitasObj();
                    $citas =filtrarCitasPorMes("09",$citasAll);
                    $citas =  ordenarCitas($citas);
                    foreach ($citas as $cita):
                    ?>
                        <tr>
                            <td><?= date_format($cita->getFecha(), "Y/m/d") ?></td>
                            <td><?= $cita->getCliente()?></td>
                            <td>
                                <?php if (count($cita->getProductos()) > 0): ?>
                                    <table>
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Stock gramos</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cita->getProductos() as $key => $producto): ?>
                                                <tr>
                                                    <td><?= $producto['producto']->getNombre() ?></td>
                                                    <td><?= $producto['producto']->getPrecio() ?></td>
                                                    <td><?= $producto['producto']->getStockGramos() ?></td>
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
                                    <input type='submit' name='deleteCita' value='Eliminar'>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
    </div>
  
</body>
</html>
<?php
require_once(__DIR__."/../../../backend/service/ClienteService.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    $data = ['nombre'=> $nombre,'telefono'=> $telefono];
   createCliente($data);
    
    header('Location: ../../display.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="../../assets/styles.css">
</head>
<body>
    <h1>Add Client</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required>
        <br>
        <input type="submit" value="Añadir cliente"></input>
    </form>
    <li><a href="../../display.php">Volver</a></li>
</body>
</html>

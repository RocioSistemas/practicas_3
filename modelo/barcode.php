<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'empleado') {
    header("Location:../index.php");
    exit;
}
require '../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorHTML;

$generator = new BarcodeGeneratorHTML();
$codigo = $_SESSION['legajo']; // Legajo como código

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código de Barras</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            padding-top: 120px;
            min-height: 100vh;
            box-sizing: border-box;
        }
        h2 {
            font-size: 36px;
            margin-bottom: 30px;
        }
        .barcode-container {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
        }
        .barcode {
            font-size: 60px;
        }
        .button {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            margin: 10px;
            display: inline-block;
        }
        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>Código de barras de ' . htmlspecialchars($_SESSION['nombre']) . '</h2>
    <div class="barcode-container">
        <div class="barcode">'
            . $generator->getBarcode($codigo, $generator::TYPE_CODE_128, 4, 100) .
        '</div>
    </div>
    <a href="empleado.php" class="button">Volver</a>
    <a href="enviar_barras.php" class="button">Enviar a mi correo</a>
</body>
</html>';
?>


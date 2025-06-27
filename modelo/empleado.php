<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon.jpg">
    <title>Empleado</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('https://www.microtech.es/hubfs/recursos_humanos_capital_humano.jpg'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .contenido {
            text-align: center;
        }

        h1 {
            color: #00838F;
            font-size: 4em;
            margin-bottom: 40px;
            margin-top: -150px;
        }

        h3 {
            color: #00838F;
            margin-top: 50px;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            max-width: 300px;
            width: 100%;
            text-align: center;
            margin: 30px auto 0;
        }

        input[type="button"],
        input[type="submit"] {
            background-color: #A3E4D7;
            border: none;
            color: black;
            padding: 10px 20px;
            font-size: 1em;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 10px 0;
            width: 100%;
        }

        input[type="button"]:hover,
        input[type="submit"]:hover {
            background-color: #45B39D;
        }

        .button-group input[type="button"] {
            background-color: #2E86C1;
            color: white;
        }

        .button-group input[type="button"]:hover {
            background-color: #37474F;
        }

        .button-group {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'empleado') {
    header("Location:../index.php");
    exit;
}
?>

<div class="contenido">
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>

    <!-- Formulario principal con botones -->
    <form>
    <input type="button" value="Ver mi código de barras" onClick="location.href='barcode.php'">
    <input type="button" value="Mostrar mis datos" onClick="location.href='misDatos.php'">
    <input type="button" value="Cambiar contraseña" onClick="location.href='cambiar_clave.php'">
    <div class="button-group">
        <input type="button" value="Cerrar Sesión" onClick="location.href='logout.php'">
    </div>
</form>

</div>

</body>
</html>

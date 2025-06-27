<!DOCTYPE html>
<html>
<head>
    <title>Registro de Empleado</title>
    <meta charset="utf-8">
    <link rel="icon" href="icon.jpg">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('https://www.esan.edu.pe/images/blog/2020/06/02/x1500x844-imagen3.jpg.pagespeed.ic.MHPsI14v-w.jpg'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h3 {
            color: #000;
            font-size: 1.5em; 
            margin: 0;
        }

        a {
            text-decoration: none;
            color: #F8F9F9;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            background-color: #45B39D;
            padding: 10px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #7986CB;
        }
    </style>
</head>
<body>
<div class="container">
<?php
$conexion = mysqli_connect("localhost", "root", "", "recursosdb") or die("Problemas con la conexión");

$nombre = $_REQUEST["Nombre"];
$apellido = $_REQUEST["Apellido"];
$dni = $_REQUEST["DNI"];
$nro_legajo = $_REQUEST["nro_legajo"];
$telefono = $_REQUEST["Telefono"];
$email = $_REQUEST["Email"];
$codigo_barras = $nro_legajo;

// La contraseña inicial será el DNI, pero hasheada
$claveHash = password_hash($dni, PASSWORD_DEFAULT);

// Ejecutar el insert con la clave hasheada
mysqli_query($conexion, "INSERT INTO empleados(nombre, apellido, dni, nro_legajo, telefono, email, codigo_barras, clave)
    VALUES ('$nombre', '$apellido', '$dni', '$nro_legajo', '$telefono', '$email', '$codigo_barras', '$claveHash')")
    or die("Problemas en el insert: " . mysqli_error($conexion));

mysqli_close($conexion);



// Mostramos mensaje de alta
echo "<h3>El empleado fue dado de alta.</h3>";
?>
<a href="listaEmpleados.php">Ver lista de empleados</a>

</div>
</body>
</html>





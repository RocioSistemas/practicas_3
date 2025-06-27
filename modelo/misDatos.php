<?php
session_start();

// Verificamos que haya sesión de empleado activa
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'empleado') {
    header("Location: index.php");
    exit;
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "recursosdb") or die("Error al conectar con la base de datos");

$dni = $_SESSION['dni'];

$consulta = mysqli_query($conexion, "SELECT * FROM empleados WHERE dni = '$dni'")
            or die("Error en la consulta: " . mysqli_error($conexion));

if ($empleado = mysqli_fetch_array($consulta)) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F2F3F4;
            margin: 0;
            padding: 20px;
        }

        .contenedor {
            background-color: #fff;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #00838F;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        td:first-child {
            font-weight: bold;
            color: #2C3E50;
            width: 40%;
        }

        .boton {
            display: block;
            margin: 30px auto 0;
            background-color: #00838F;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }

        .boton:hover {
            background-color: #005f63;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Mis Datos</h2>
    <table>
        <tr><td>Nombre:</td><td><?php echo $empleado['nombre']; ?></td></tr>
        <tr><td>Apellido:</td><td><?php echo $empleado['apellido']; ?></td></tr>
        <tr><td>DNI:</td><td><?php echo $empleado['dni']; ?></td></tr>
        <tr><td>Legajo:</td><td><?php echo $empleado['nro_legajo']; ?></td></tr>
        <tr><td>Teléfono:</td><td><?php echo $empleado['telefono']; ?></td></tr>
        <tr><td>Email:</td><td><?php echo $empleado['email']; ?></td></tr>
        <tr><td>Rol:</td><td><?php echo $empleado['rol']; ?></td></tr>
    </table>

    <a class="boton" href="empleado.php">Volver</a>
</div>

</body>
</html>

<?php
} else {
    echo "Empleado no encontrado.";
}

mysqli_close($conexion);
?>

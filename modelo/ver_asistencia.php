<?php
session_start();

// Verifica que sea un administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "recursosdb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta con JOIN para unir asistencia con empleados
$sql = "SELECT a.fecha, a.horaEntrada, a.horaSalida, e.nombre, e.apellido, e.nro_legajo
        FROM asistencia a
        JOIN empleados e ON a.nro_legajo = e.nro_legajo
        ORDER BY a.fecha DESC, a.horaEntrada DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registros de Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F0F8F8;
            padding: 30px;
            text-align: center;
        }

        h2 {
            color: #117864;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #117864;
            color: white;
        }

        tr:hover {
            background-color: #D1F2EB;
        }

        button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #117864;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
        }

        button:hover {
            background-color: #0E6655;
        }
    </style>
</head>
<body>
    <h2>Registros de Asistencia</h2>

    <?php
    if ($resultado->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Legajo</th><th>Nombre</th><th>Apellido</th><th>Fecha</th><th>Entrada</th><th>Salida</th></tr>";
        
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila['nro_legajo'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['apellido'] . "</td>";
            echo "<td>" . $fila['fecha'] . "</td>";
            echo "<td>" . $fila['horaEntrada'] . "</td>";
            echo "<td>" . ($fila['horaSalida'] ?? '-') . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hay registros de asistencia.</p>";
    }

    $conexion->close();
    ?>
        <button onclick="window.location.href='exportar_asistencia.php'">Exportar a Excel</button>
    <button onclick="window.location.href='lector_codigos.php'">Volver al escáner</button>
    <button onclick="window.location.href='../vista/admin.html'">Volver al inicio</button>
</body>
</html>

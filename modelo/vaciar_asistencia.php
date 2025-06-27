<?php
$conexion = new mysqli("localhost", "root", "", "recursosdb");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "DELETE FROM asistencia";

if ($conexion->query($sql) === TRUE) {
    echo "La tabla asistencia se vació correctamente.";
} else {
    echo "Error al vaciar la tabla: " . $conexion->error;
}

$conexion->close();
?>

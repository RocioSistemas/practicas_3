<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empleados</title>
    <meta charset="Utf-8">
    <link rel="icon" href="icon.jpg">
    <link rel="stylesheet" type="text/css" href="estilo.css">
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
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            width: 100%;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 1.2em;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            color: #00838F;
            margin-top: 0;
            font-size: 3em;
        }
        a {
            text-decoration: none;
            color: #F8F9F9;
            font-weight: bold;
            background-color: #45B39D; /* verde oscuro para el botón */
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            background-color: #7986CB; /* AZUL OPACO al pasar el ratón */
        }

      
    </style>
</head>
<body>
    <div class="container">
        <h1>LISTA DE EMPLEADOS</h1>
        <?php
$mysqli = new mysqli("localhost", "root", "", "recursosdb");
if ($mysqli->connect_error) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}
$sql = "SELECT * FROM empleados";
$result = $mysqli->query($sql);
if ($result === false) {
    die("Error en la consulta: " . $mysqli->error);
}
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<thead>";
echo "<tr>";
echo "<th>Nombre</th>";
echo "<th>Apellido</th>";
echo "<th>DNI</th>";
echo "<th>Nro Legajo</th>";
echo "<th>Teléfono</th>";
echo "<th>Email</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
while ($fila = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$fila['apellido']."</td>";
    echo "<td>".$fila['dni']."</td>";
    echo "<td>".$fila['nro_legajo']."</td>";
    echo "<td>".$fila['telefono']."</td>";
    echo "<td>".$fila['email']."</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
$mysqli->close();
?>
<br>
        <a href="../vista/altaEmpleados.html">Dar de alta un empleado</a>
        <a href="bajas.php">Dar de baja un empleado</a>
        <a href="../vista/admin.html">Ir al menú principal</a>
    </div>
</body>
</html>

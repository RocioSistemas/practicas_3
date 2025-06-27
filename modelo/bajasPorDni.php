<!DOCTYPE html>
<html>
<head>
    <title>Baja de Empleados</title>
    <meta charset="UTF-8">
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
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #000;
            font-size: 2em;
            margin-top: 0;
        }

        p {
            color: #000;
            font-size: 1.2em;
            margin: 20px 0;
        }

        a {
            text-decoration: none;
            color: #F8F9F9;
            font-weight: bold;
            background-color: #A3E4D7; /* verde para el botón */
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            background-color: #45B39D; /* verde más oscuro al pasar el ratón */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
$conexion = mysqli_connect("localhost", "root", "", "recursosdb") or die("Problemas con la conexión");

$dni = $_REQUEST["DNI"];

// Preparar SELECT
$stmt = mysqli_prepare($conexion, "SELECT dni FROM empleados WHERE dni = ?");
mysqli_stmt_bind_param($stmt, "s", $dni);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    // Si existe, preparar DELETE
    $deleteStmt = mysqli_prepare($conexion, "DELETE FROM empleados WHERE dni = ?");
    mysqli_stmt_bind_param($deleteStmt, "s", $dni);
    mysqli_stmt_execute($deleteStmt);

    echo "<p>Se efectuó la baja del empleado con el DNI ingresado.</p>";

    mysqli_stmt_close($deleteStmt);
} else {
    echo "<p>No existe empleado con el DNI ingresado.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
<a href="listaEmpleados.php">Visualizar Lista de Empleados</a>

    
    </div>
</body>
</html>

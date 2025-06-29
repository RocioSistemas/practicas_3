<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Datos</title>
    <link rel="icon" href="icon.jpg">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('https://accendo.pt/wp-content/uploads/2020/01/recursos-humanos.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #00838F;
            font-size: 2em;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
input[type="submit"] {
    background-color: #A3E4D7;
    color: black;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input[type="submit"]:hover {
    background-color: #45B39D;
}

       input[type="submit"] {
    background-color: #A3E4D7;
    color: black;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 1em;
    padding: 10px;
}


        input[type="submit"]:hover {
            background-color: #45B39D;
        }

        p {
            color: #333;
            font-weight: bold;
        }
       

    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modificar datos del empleado</h2>

        <?php
        $conexion = mysqli_connect("localhost", "root", "", "recursosdb") or die("Problemas de conexión");

        if (isset($_POST['actualizar'])) {
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $email = $_POST['email'];

            mysqli_query($conexion, "UPDATE empleados 
                SET dni= '$dni', nombre='$nombre', apellido='$apellido', telefono='$telefono', email='$email' 
                WHERE dni='$dni'")
                or die("Error al actualizar: " . mysqli_error($conexion));

            echo "<p>Datos actualizados correctamente.</p>";
        }

        if (isset($_POST['buscar'])) {
            $dniBuscar = $_POST['dni_buscar'];
            $registro = mysqli_query($conexion, "SELECT * FROM empleados WHERE dni='$dniBuscar'")
                or die("Error en la búsqueda: " . mysqli_error($conexion));

            if ($reg = mysqli_fetch_array($registro)) {
                ?>
                <form method="post">
                    <input type="hidden" name="dni" value="<?php echo $reg['dni']; ?>">
                    <input type="text" name="dni" value="<?php echo $reg['dni']; ?>" placeholder="Dni"><br>
                    <input type="text" name="nombre" value="<?php echo $reg['nombre']; ?>" placeholder="Nombre"><br>
                    <input type="text" name="apellido" value="<?php echo $reg['apellido']; ?>" placeholder="Apellido"><br>
                    <input type="text" name="telefono" value="<?php echo $reg['telefono']; ?>" placeholder="Teléfono"><br>
                    <input type="email" name="email" value="<?php echo $reg['email']; ?>" placeholder="Email"><br>
                    <input type="submit" name="actualizar" value="Actualizar Y Volver">
                </form>
                <?php
            } else {
                echo "<p>No se encontró un empleado con ese DNI.</p>";
            }
        } else {
            ?>
            <form method="post" style="margin-bottom: 15px;">
    <input type="text" name="dni_buscar" placeholder="Ingrese DNI del empleado" required>
<input type="submit" name="buscar" value="Buscar">
</form>

<!-- Botones para Menú Principal y Ver Lista -->
<div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
    <form action="../vista/admin.html" method="get" style="flex: 1;">
        <input type="submit" value="Volver al menú principal" style="width: 100%; padding: 8px 15px; font-size: 0.9em;">
    </form>

    <form action="listaEmpleados.php" method="get" style="flex: 1;">
        <input type="submit" value="Ver lista de empleados" style="width: 100%; padding: 8px 15px; font-size: 0.9em;">
    </form>
</div>

<?php
}
mysqli_close($conexion);
?>

 </div>
</body>
</html>




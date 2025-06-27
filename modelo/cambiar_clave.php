<?php
session_start();
if (!isset($_SESSION['dni'])) {
    echo "<script>alert('No hay DNI en sesión.'); window.location='../index.php';</script>";
    exit;
} else {
    // Para debug solo: muestra el DNI (puedes comentar después)
    // echo "DNI en sesión: " . $_SESSION['dni'];
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'empleado') {
    header("Location: index.php");
    exit;
}

$conexion = mysqli_connect("localhost", "root", "", "recursosdb") or die("Problemas con la conexión");

// Función para sanitizar entradas
function limpiar($dato) {
    return htmlspecialchars(trim($dato));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_SESSION['dni'];
    $clave_actual = limpiar($_POST['clave_actual'] ?? '');
    $nueva_clave = limpiar($_POST['nueva_clave'] ?? '');

    if (empty($clave_actual) || empty($nueva_clave)) {
        echo "<script>alert('Por favor, complete todos los campos'); window.history.back();</script>";
        exit;
    }

    // Obtener la clave almacenada en la DB (hashed)
    $consulta = mysqli_query($conexion, "SELECT clave FROM empleados WHERE dni = '$dni'") or die("Error en la consulta");

    if ($fila = mysqli_fetch_assoc($consulta)) {
        $clave_db = $fila['clave'];

        // Si la clave en DB está vacía (primer cambio), se compara con dni (sin hash)
        if (empty($clave_db)) {
            if ($clave_actual !== $dni) {
                echo "<script>alert('Contraseña actual incorrecta'); window.history.back();</script>";
                exit;
            }
        } else {
            // Si la clave está hasheada, verificamos con password_verify
            if (!password_verify($clave_actual, $clave_db)) {
                echo "<script>alert('Contraseña actual incorrecta'); window.history.back();</script>";
                exit;
            }
        }

        // Hasheamos la nueva clave antes de guardar
        $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);

        $update = mysqli_query($conexion, "UPDATE empleados SET clave = '$clave_hash' WHERE dni = '$dni'");

        if ($update) {
            echo "<script>alert('Contraseña cambiada con éxito'); window.location.href='empleado.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar la contraseña'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No se encontró el usuario'); window.history.back();</script>";
    }

    mysqli_close($conexion);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            width: 300px;
            text-align: center;
        }
        input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #00838F;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #005f61;
        }
        a {
            display: block;
            margin-top: 15px;
            color: #00838F;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<form method="POST" action="cambiar_clave.php">
    <h2>Cambiar contraseña</h2>
    <label>Clave actual:</label>
    <input type="password" name="clave_actual" required>

    <label>Nueva clave:</label>
    <input type="password" name="nueva_clave" required>

    <input type="submit" value="Cambiar clave">
     <button type="button" onclick="window.location.href='empleado.php'" 
        style="
            width: 100%; 
            padding: 10px; 
            margin-top: 10px; 
            border-radius: 5px; 
            border: none; 
            background-color: #00838F; 
            color: white; 
            font-weight: bold; 
            cursor: pointer;
            transition: background-color 0.3s ease;
        "
        onmouseover="this.style.backgroundColor='#005f61'"
        onmouseout="this.style.backgroundColor='#00838F'"
    >Volver</button>
</form>

</body>
</html>

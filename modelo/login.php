<?php
session_start();

$conexion = mysqli_connect("localhost", "root", "", "recursosdb") or die("Problemas con la conexión");

$usuario = trim($_POST['usuario']);
$clave = trim($_POST['clave']);

// Acceso administrador
if ($usuario == "admin" && $clave == "admin") {
    $_SESSION['rol'] = 'admin';
    header("Location:../vista/admin.html");
    exit;
}

// Busco por DNI
$consulta = mysqli_query($conexion, "SELECT * FROM empleados WHERE dni = '$usuario'")
            or die("Error en la consulta: " . mysqli_error($conexion));

if ($empleado = mysqli_fetch_array($consulta)) {
    // Si la clave está vacía (sin establecer), permito el login si la clave ingresada es igual al DNI
    if (empty($empleado['clave'])) {
        if ($clave === $empleado['dni']) {
            $_SESSION['rol'] = 'empleado';
            $_SESSION['legajo'] = $empleado['nro_legajo'];
            $_SESSION['nombre'] = $empleado['nombre'];
            $_SESSION['dni'] = $empleado['dni'];
            header("Location: empleado.php");
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='index.php';</script>";
            exit;
        }
    } else {
        // La clave está guardada como hash, verifico con password_verify
        if (password_verify($clave, $empleado['clave'])) {
            $_SESSION['rol'] = 'empleado';
            $_SESSION['legajo'] = $empleado['nro_legajo'];
            $_SESSION['nombre'] = $empleado['nombre'];
            $_SESSION['dni'] = $empleado['dni'];
            header("Location: empleado.php");
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='index.php';</script>";
            exit;
        }
    }
} else {
    echo "<script>alert('DNI no registrado'); window.location='index.php';</script>";
    exit;
}

mysqli_close($conexion);
?>

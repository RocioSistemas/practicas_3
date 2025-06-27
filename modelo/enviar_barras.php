<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'empleado') {
    header("Location:../index.php");
    exit;
}

require '../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conectar a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'recursosdb'); // Cambiar datos reales

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

// Buscar datos del empleado por su legajo
$nro_legajo = $_SESSION['legajo'];
$stmt = $mysqli->prepare("SELECT nombre, apellido, email FROM empleados WHERE nro_legajo = ?");
$stmt->bind_param("s", $nro_legajo);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $email);
$stmt->fetch();
$stmt->close();
$mysqli->close();

// Si no se encuentra el correo, abortar
if (empty($email)) {
    die('No se encontró el correo del empleado.');
}

// Generar código de barras y guardarlo como archivo
$generator = new BarcodeGeneratorPNG();
$barcodeData = $generator->getBarcode($nro_legajo, $generator::TYPE_CODE_128, 4, 100);
$barcodePath = 'codigo_barra.png';
file_put_contents($barcodePath, $barcodeData); // Guardar imagen en el servidor

// Configurar PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'miguesanz11@gmail.com'; // Tu correo
    $mail->Password = 'xpoxravlsccirnzp';       // Tu contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom('miguesanz11@gmail.com', 'Recursos Humanos');
    $mail->addAddress($email, "$nombre $apellido");

    // Adjuntar imagen para visualizarla dentro del correo
    $mail->addEmbeddedImage($barcodePath, 'barcode_img');

    // Adjuntar imagen como archivo descargable
    $mail->addAttachment($barcodePath, 'codigo_barras.png');

    $mail->isHTML(true);
    $mail->Subject = 'Tu código de barras para fichar';
    $mail->Body = "
        <p>Hola <strong>$nombre $apellido</strong>,</p>
        <p>Este es tu código de barras personal para fichar:</p>
        <img src='cid:barcode_img' alt='Código de Barras'><br><br>
        <p>Te recomendamos guardar esta imagen en tu celular.</p>
        <p>Saludos,<br>RRHH</p>
    ";

    $mail->send();
    echo 'El correo fue enviado correctamente a ' . htmlspecialchars($email) . '<br><br>';
    echo '<form action="empleado.php" method="get">';
    echo '<button type="submit" style="padding:12px 24px; background-color:#007BFF; color:white; border:none; border-radius:5px; font-size:16px; cursor:pointer;">Volver</button>';
    echo '</form>';
    

    // Borrar el archivo temporal del servidor
    unlink($barcodePath);

} catch (Exception $e) {
    echo 'Error al enviar el correo: ', $mail->ErrorInfo;
}
?>

<?php
ob_start(); // Comienza el buffer de salida

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "recursosdb");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$sheet->setCellValue('A1', 'Legajo');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Apellido');
$sheet->setCellValue('D1', 'Fecha');
$sheet->setCellValue('E1', 'Entrada');
$sheet->setCellValue('F1', 'Salida');

// Consulta SQL
$sql = "SELECT a.fecha, a.horaEntrada, a.horaSalida, e.nombre, e.apellido, e.nro_legajo
        FROM asistencia a
        JOIN empleados e ON a.nro_legajo = e.nro_legajo
        ORDER BY a.fecha DESC, a.horaEntrada DESC";

$resultado = $conexion->query($sql);

// Llenar datos
$row = 2;
while ($fila = $resultado->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $fila['nro_legajo']);
    $sheet->setCellValue('B' . $row, $fila['nombre']);
    $sheet->setCellValue('C' . $row, $fila['apellido']);
    $sheet->setCellValue('D' . $row, $fila['fecha']);
    $sheet->setCellValue('E' . $row, $fila['horaEntrada']);
    $sheet->setCellValue('F' . $row, $fila['horaSalida'] ?? '-');
    $row++;
}

// Ajustar ancho de columnas automáticamente
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Estilo encabezado
$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Bordes a todo el contenido
$lastRow = $row - 1;
$contentStyle = [
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];
$sheet->getStyle("A1:F$lastRow")->applyFromArray($contentStyle);

// Congelar la fila de encabezado (opcional)
$sheet->freezePane('A2');

// Encabezados para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="asistencia.xlsx"');
header('Cache-Control: max-age=0');

// Enviar archivo
$writer = new Xlsx($spreadsheet);
ob_end_clean(); // Elimina cualquier salida previa
$writer->save('php://output');

// Cerrar conexión
$conexion->close();
exit;
?>

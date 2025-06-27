<?php
$conexion = new mysqli("localhost", "root", "", "recursosdb");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Detectar la sección activa según lo enviado por POST
$seccion_activa = 'asistencias'; // por defecto

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['buscar'])) {
    $seccion_activa = 'buscar';
  } elseif (isset($_POST['desde']) && isset($_POST['hasta'])) {
    $seccion_activa = 'rango';
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Reportes</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    header { background-color: #00838f; color: white; padding: 20px; text-align: center; }
    nav { background-color: #e0f2f1; padding: 15px; text-align: center; }
    nav button {
      margin: 10px;
      padding: 10px 20px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      border: none;
      background-color: #a3e4d7;
    }
    section { padding: 30px; display: none; }
    section.active { display: block; }
    h2 { color: #00695c; }
    .volver { margin-top: 30px; }
  </style>
</head>
<body>

  <header>
    <h1>PANEL DE REPORTES</h1>
  </header>

  <nav>
    <button onclick="mostrarSeccion('asistencias')"> VER ASISTENCIAS</button>
    <button onclick="mostrarSeccion('inasistencias')"> INASISTENCIAS</button>
    <button onclick="mostrarSeccion('tardanzas')"> LLEGADAS TARDE</button>
    <button onclick="mostrarSeccion('rango')"> POR RANGO DE FECHAS</button>
    <button onclick="mostrarSeccion('buscar')"> BUSCAR POR LEGAJO / APELLIDO</button>
    <button onclick="mostrarSeccion('volver')"> VOLVER</button>
  </nav>

  <main>
    <section id="asistencias" class="<?= $seccion_activa === 'asistencias' ? 'active' : '' ?>">
      <h2>📋 Todas las asistencias</h2>
      <?php
        $consulta = $conexion->query("SELECT * FROM asistencia");
        echo "<table border='1'><tr><th>Legajo</th><th>Fecha</th><th>Entrada</th><th>Salida</th></tr>";
        while($fila = $consulta->fetch_assoc()) {
          echo "<tr><td>{$fila['nro_legajo']}</td><td>{$fila['fecha']}</td><td>{$fila['horaEntrada']}</td><td>{$fila['horaSalida']}</td></tr>";
        }
        echo "</table>";
      ?>
    </section>

    <section id="inasistencias" class="<?= $seccion_activa === 'inasistencias' ? 'active' : '' ?>">
      <h2>❌ Reporte de Inasistencias</h2>
      <?php
      function obtenerFechasLaborales($mes, $anio) {
          $fechas = [];
          $diasEnMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
          for ($i = 1; $i <= $diasEnMes; $i++) {
              $fecha = "$anio-" . str_pad($mes, 2, "0", STR_PAD_LEFT) . "-" . str_pad($i, 2, "0", STR_PAD_LEFT);
              $diaSemana = date("N", strtotime($fecha));
              if ($diaSemana < 6) { $fechas[] = $fecha; }
          }
          return $fechas;
      }

      $mesActual = date("m");
      $anioActual = date("Y");
      $fechasLaborales = obtenerFechasLaborales($mesActual, $anioActual);

      $empleados = $conexion->query("SELECT nro_legajo, nombre FROM empleados");

      echo "<table border='1'>";
      echo "<tr><th>Legajo</th><th>Nombre</th><th>Fecha de inasistencia</th></tr>";

      while ($emp = $empleados->fetch_assoc()) {
          $legajo = $emp['nro_legajo'];
          $nombre = $emp['nombre'];
          foreach ($fechasLaborales as $fecha) {
              $query = $conexion->query("SELECT 1 FROM asistencia WHERE nro_legajo = '$legajo' AND fecha = '$fecha'");
              if ($query->num_rows == 0) {
                  echo "<tr><td>$legajo</td><td>$nombre</td><td>$fecha</td></tr>";
              }
          }
      }
      echo "</table>";
      ?>
    </section>

    <section id="tardanzas" class="<?= $seccion_activa === 'tardanzas' ? 'active' : '' ?>">
      <h2>⏰ Llegadas tarde</h2>
      <?php
        $consultaTarde = $conexion->query("SELECT * FROM asistencia WHERE llego_tarde = 1");
        echo "<table border='1'><tr><th>Legajo</th><th>Fecha</th><th>Hora Entrada</th></tr>";
        while($fila = $consultaTarde->fetch_assoc()) {
          echo "<tr><td>{$fila['nro_legajo']}</td><td>{$fila['fecha']}</td><td>{$fila['horaEntrada']}</td></tr>";
        }
        echo "</table>";
      ?>
    </section>

    <section id="rango" class="<?= $seccion_activa === 'rango' ? 'active' : '' ?>">
      <h2>📈 Asistencias por rango de fechas</h2>
      <form method="POST" action="">
        Desde: <input type="date" name="desde">
        Hasta: <input type="date" name="hasta">
        <button type="submit">Filtrar</button>
      </form>
      <?php
        if ($seccion_activa === 'rango') {
          $desde = $_POST['desde'];
          $hasta = $_POST['hasta'];
          $consultaRango = $conexion->query("SELECT * FROM asistencia WHERE fecha BETWEEN '$desde' AND '$hasta'");
          echo "<table border='1'><tr><th>Legajo</th><th>Fecha</th><th>Hora Entrada</th><th>Hora Salida</th></tr>";
          while($fila = $consultaRango->fetch_assoc()) {
            echo "<tr><td>{$fila['nro_legajo']}</td><td>{$fila['fecha']}</td><td>{$fila['horaEntrada']}</td><td>{$fila['horaSalida']}</td></tr>";
          }
          echo "</table>";
        }
      ?>
    </section>

    <section id="buscar" class="<?= $seccion_activa === 'buscar' ? 'active' : '' ?>">
      <h2>🔍 Buscar por legajo o apellido</h2>
      <form method="POST" action="">
        Buscar: <input type="text" name="buscar">
        <button type="submit">Buscar</button>
      </form>
      <?php
        if ($seccion_activa === 'buscar') {
          $buscar = $conexion->real_escape_string($_POST['buscar']);
          $consultaBuscar = $conexion->query("
            SELECT a.*, e.apellido 
            FROM asistencia a 
            JOIN empleados e ON a.nro_legajo = e.nro_legajo 
            WHERE e.apellido LIKE '%$buscar%' OR a.nro_legajo = '$buscar'
          ");
          if ($consultaBuscar->num_rows > 0) {
            echo "<table border='1'><tr><th>Apellido</th><th>Legajo</th><th>Fecha</th><th>Entrada</th><th>Salida</th></tr>";
            while($fila = $consultaBuscar->fetch_assoc()) {
              echo "<tr><td>{$fila['apellido']}</td><td>{$fila['nro_legajo']}</td><td>{$fila['fecha']}</td><td>{$fila['horaEntrada']}</td><td>{$fila['horaSalida']}</td></tr>";
            }
            echo "</table>";
          } else {
            echo "<p>No se encontraron resultados para <strong>$buscar</strong>.</p>";
          }
        }
      ?>
    </section>
  </main>

  <script>
    src="../controlador/mostrarSeccion.js"
  </script>

</body>
</html>


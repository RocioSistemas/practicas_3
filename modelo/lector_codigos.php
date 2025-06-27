<?php
session_start();

// Verifica que sea un administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lector de Códigos</title>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F0F8F8;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 30px;
        }

        video {
            width: 300px;
            height: auto;
            border: 4px solid #117864;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        #output {
            font-size: 1.2em;
            color: #0B5345;
            font-weight: bold;
        }

        button {
            padding: 10px 20px;
            margin-top: 15px;
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

        input[type="text"] {
            padding: 10px;
            font-size: 1em;
            margin-top: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h2>Escáner de Códigos de Barras</h2>
    <video id="video"></video>
    <div id="output">Esperando escaneo...</div>

    <!-- Campo para ingresar número de legajo manualmente -->
    <div>
        <input type="text" id="legajo" name="legajo" placeholder="Ingrese nro de legajo" />
        <button onclick="registrarLegajoManual()">Registrarse</button>
    </div>

   <!-- Nuevo botón agregado -->
    <button onclick="window.location.href='ver_asistencia.php'">Ver registros de asistencia</button>


    <button onclick="window.location.href='../vista/admin.html'">Volver</button>

    
    <script>
        const codeReader = new ZXing.BrowserBarcodeReader();
        const videoElement = document.getElementById('video');
        const output = document.getElementById('output');

        // Función para registrar el código de barras escaneado
        function registrarCodigo(codigo) {
            // Enviar el código leído a un script PHP para registrar la asistencia
            fetch('registrar_asistencia.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'codigo=' + encodeURIComponent(codigo)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                output.textContent = 'Esperando nuevo escaneo...';
            });
        }

        // Función para manejar el escaneo del código de barras
        codeReader.getVideoInputDevices()
            .then((videoInputDevices) => {
                const selectedDeviceId = videoInputDevices[0].deviceId;

                codeReader.decodeFromVideoDevice(selectedDeviceId, videoElement, (result, err) => {
                    if (result) {
                        output.textContent = 'Código leído: ' + result.text;
                        registrarCodigo(result.text); // Registrar el código leído
                        codeReader.reset(); // Parar escaneo
                    }
                });
            })
            .catch((err) => {
                console.error(err);
                output.textContent = 'Error al acceder a la cámara.';
            });

        // Función para registrar el número de legajo ingresado manualmente
        function registrarLegajoManual() {
            const legajo = document.getElementById('legajo').value;

            if (legajo) {
                output.textContent = 'Número de legajo ingresado: ' + legajo;
                registrarCodigo(legajo); // Registrar el código ingresado manualmente
            } else {
                output.textContent = 'Por favor, ingrese un número de legajo.';
            }
        }
    </script>
</body>
</html>

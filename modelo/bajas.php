<!DOCTYPE html>
<html>
<head>
    <title>BAJA DE EMPLEADOS</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="icon" href="icon.jpg">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('https://grupovertice.com/blog/wp-content/uploads/2022/11/human-resources-and-people-networking-concept-scaled.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        form {
            background-color: rgba(255, 255, 255, 0.6);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1, h2 {
            margin: 0;
            color: #00838F;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 1em;
            margin-top: 20px;
            color: #45B39D;
        }

        input[type="text"] {
            width: calc(100% - 40px);
            height: 30px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            margin-bottom: 20px;
            font-weight: bold;

        }

        input[type="submit"] {
            background-color: #A3E4D7;
    border: none;
    color: black;
    padding: 15px 20px; /* Más alto y más ancho internamente */
    font-size: 1.1em; /* Texto un poquito más grande */
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 60%; /* Un poco más ancho */
    margin: 20px auto 0 auto; /* Espaciado superior y centrado */
    display: block; /* Para que respete el margen auto y quede centrado */
    font-weight: bold;

        }

        input[type="submit"]:hover {
            background-color: #45B39D; /* Color verde más oscuro */
        }

        a {
            text-decoration: none;
            color: #00838F;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form action="bajasPorDni.php" method="post">
        <h1>BAJA DE EMPLEADOS</h1>
        <br>
        <input type="text" name="DNI" placeholder="Ingrese el DNI del empleado">
        <input type="submit" value="Dar de Baja">
        <h3><a href="../vista/altaEmpleados.html">Dar de alta un empleado</a></h3>
        <h3><a href="listaEmpleados.php">Ver lista de empleados</a></h3>
        <h3><a href="../vista/admin.html">Ir al menú principal</a></h3>
    </form>
</body>
</html>

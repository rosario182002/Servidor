<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividad 1</title>
</head>
<body>
    <form action="#" method="POST">
        <p>Nombre: <input type="text" name="nombre"></p>

        <p>Apellidos: <input type="text" name="apellidos"></p>

        <p>Edad: <input type="number" name="edad"></p>

        <p><input type="submit" value="Enviar"></p>
    </form>

    <?php
    
    $nombre = $_REQUEST["nombre"];
    $apellidos = $_REQUEST["apellidos"];
    $edad = $_REQUEST["edad"];
    echo $nombre;
    echo $apellidos;
    echo $edad;

    ?>

</body>
</html>
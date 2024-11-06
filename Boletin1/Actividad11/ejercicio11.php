<?php
error_reporting(0); //para cuando no tengamos la variable asignada con un valor
    $nombre = $_REQUEST["Nombre"];
    echo "Hola ", $nombre;
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <form action="#">
    <p>Nombre: <input type="text" name="Nombre" method='post'></p>
    <p><input type="submit" value="Enviar"></p>
    </form>
    
</body>
</html>
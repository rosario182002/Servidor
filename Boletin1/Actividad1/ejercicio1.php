<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Personales</title>
    
</head>
<body>

<?php 
//variable para los datos
$nombre = "Rosario";
$primerApellido ="Delgado";
$segundoApellido ="Moreno";
$curso ="2ºDAW";

//imprimir datos
echo "<h1>Datos del estudiante</h1>";
echo "<p>Nombre: $nombre</p>";
echo "<p>Primer Apellido: $primerApellido</p>";
echo "<p>Segundo Apellido: $segundoApellido</p>";
echo "<p>Curso: $curso</p>";

//para añadir foto
$fotoDNI = "dni.jpg";

//para mostral la foto
echo "<img src=$fotoDNI width:100;height:100px;>";
//hacer lo de la imagen 
?>
</body>
</html>
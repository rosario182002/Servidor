<?php
$temp = array();
$temp[0] = 16;
$temp[1] = 15;
$temp[2] = 17;
$temp[3] = 15;
$temp[4] = 16;

//para obtener temperatura del cuarto dia
$temperatura_cuarto_dia = $temp[3];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperatura en Málaga</title>
</head>
<body>
    
<h1>Temperatura en Málaga</h1>
<p><?php echo "La temperatura en Málaga el cuarto día del año fue de $temperatura_cuarto_dia °C."; ?></p>
    
</body>
</html>
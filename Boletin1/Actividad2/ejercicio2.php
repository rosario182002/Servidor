<?php
    $radio =4;
    $pi = pi();
    $area = $pi*$radio**2;
    $circunferencia = 2*pi()*$radio;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALCULO DEL CIRCULO</title>
</head>
<body>
    <h1>Cáluculo de un Círculo de radio </h1>
    <p>Área: <?php echo number_format($area,2); ?> </p>
    <p>$circunferencia: <?php echo number_format($circunferencia, 2); ?> unidades</p>
</body>
</html>







<?php
$num1 =10;
$num2 =7;;

$suma = $num1 + $num2;
$resta = $num1 - $num2;
$multiplicacion = $num1 * $num2;
$division = $num1 / $num2;
$modulo = $num1 % $num2;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orepaciones con 10 y 7</title>
</head>
<body>
    
    <h1>Operaciones con los numero 10 y 7</h1>
    <p>Suma: <?php echo  "$num1 + $num2 = $suma"; ?></p>
    <p>Resta: <?php echo "$num1 - $num2 = $resta"; ?></p>
    <p>Multiplicación: <?php echo "$num1 * $num2 = $multiplicacion"; ?></p>
    <p>División: <?php echo "$num1 / $num2 = " . number_format($division, 2); ?></p>
    <p>Módulo (resto de la división): <?php echo "$num1 % $num2 = $modulo"; ?></p>

</body>
</html>
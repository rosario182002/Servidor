<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Análisis de Números</title>
</head>
<body>

<?php
// Función para verificar si un número es primo
function esPrimo($num) {
    if ($num <= 1) return false;
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) return false;
    }
    return true;
}

// Recibir los datos del formulario
$count = isset($_POST['count']) ? (int)$_POST['count'] : 1;
$numbers = isset($_POST['numbers']) ? explode(",", $_POST['numbers']) : [];
$number = isset($_POST['number']) ? (int)$_POST['number'] : 0;

// Agregar el número ingresado al arreglo de números
$numbers[] = $number;

// Si se han ingresado menos de 6 números, pedir el siguiente número
if ($count < 6) {
    $nextCount = $count + 1;
    $numbersStr = implode(",", $numbers); // Convertir el array a string para pasar en el formulario

    echo "<h1>Ingresa el número $nextCount</h1>";
    echo '<form action="procesar.php" method="POST">';
    echo "<input type='hidden' name='count' value='$nextCount'>";
    echo "<input type='hidden' name='numbers' value='$numbersStr'>";
    echo "<label for='number'>Número $nextCount:</label>";
    echo '<input type="number" name="number" required>';
    echo '<button type="submit">Enviar</button>';
    echo '</form>';
} else {
    // Calcular el máximo, el mínimo y la cantidad de números primos
    $max = max($numbers);
    $min = min($numbers);
    $primos = 0;
    foreach ($numbers as $num) {
        if (esPrimo($num)) {
            $primos++;
        }
    }

    // Mostrar los resultados
    echo "<h1>Resultados</h1>";
    echo "<p><strong>Números ingresados:</strong> " . implode(", ", $numbers) . "</p>";
    echo "<p><strong>Máximo:</strong> $max</p>";
    echo "<p><strong>Mínimo:</strong> $min</p>";
    echo "<p><strong>Cantidad de números primos:</strong> $primos</p>";
    echo '<br><a href="index.html">Volver a empezar</a>';
}
?>

</body>
</html>

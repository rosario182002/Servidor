<?php
// Inicialización de las variables
$horasTotales = 50; // Horas actuales del piloto
$maxHoras = 100;    // Máximo de horas permitidas

// Variable para el mensaje a mostrar
$mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener las horas de vuelo a añadir desde el formulario
    $horasVuelo = (int)$_POST['horasVuelo'];

    // Verificar si las horas totales más las horas a añadir superan el máximo permitido
    if (($horasTotales + $horasVuelo) > $maxHoras) {
        // Si se sobrepasan las horas, mostrar mensaje de error
        $mensaje = "Error: Las horas de vuelo exceden el máximo permitido de {$maxHoras} horas.";
    } else {
        // Si no se exceden, sumar las horas y mostrar el nuevo total
        $horasTotales += $horasVuelo;
        $mensaje = "Las horas de vuelo han sido actualizadas. El nuevo total es: {$horasTotales} horas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Control de Horas de Vuelo</title>
</head>
<body>
    <h1>Resultado del Control de Horas de Vuelo</h1>

    <!-- Mostrar el mensaje que indica si se ha superado el límite o no -->
    <p><?php echo $mensaje; ?></p>

    <!-- Botón para volver al formulario -->
    <a href="pagina.html">Volver al formulario</a>
</body>
</html>

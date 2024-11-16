<?php
// Verifica si se recibieron los valores de peso y altura
if (isset($_POST['peso']) && isset($_POST['altura'])) {
    $peso = floatval($_POST['peso']);
    $alturaCm = intval($_POST['altura']);

    // Verifica que el peso y la altura sean válidos
    if ($peso > 0 && $alturaCm > 0) {
        // Convierte la altura a metros
        $alturaM = $alturaCm / 100;

        // Calcula el IMC
        $imc = $peso / ($alturaM * $alturaM);

        // Redondea el IMC a un número entero
        $imcRedondeado = round($imc);

        // Muestra el resultado
        $resultado = "Tu IMC es: " . $imcRedondeado;
    } else {
        $resultado = "Los valores de peso y altura no son válidos. Deben ser mayores que cero.";
    }
} else {
    // Si no se reciben los datos, redirige al formulario
    header("Location: pagina.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado IMC</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Resultado del IMC</h1>

    <p><?php echo $resultado; ?></p>

    <br>
    <a href="pagina.html">Volver al formulario</a>
</body>
</html>

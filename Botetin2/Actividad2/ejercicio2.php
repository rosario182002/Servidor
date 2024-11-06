<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Conversión</title>
</head>
<body>
    <h1>Resultado de Conversión de Tipos de Datos</h1>

    <?php
    // Verificar si el formulario ha sido enviado y si 'var' está presente en $_POST
    if (isset($_POST['var'])) {
        // Recibir el valor de la variable $var desde el formulario
        $var = $_POST['var'];

        // Mostrar el valor original
        echo "<p><strong>Valor original:</strong> $var</p>";

        // Conversión a int
        $intVal = (int)$var;
        echo "<p><strong>Como int:</strong> $intVal</p>";

        // Conversión a boolean
        $boolVal = (bool)$var;
        echo "<p><strong>Como boolean:</strong> " . ($boolVal ? "true" : "false") . "</p>";

        // Conversión a string
        $strVal = (string)$var;
        echo "<p><strong>Como string:</strong> \"$strVal\"</p>";

        // Conversión a float
        $floatVal = (float)$var;
        echo "<p><strong>Como float:</strong> $floatVal</p>";
    } else {
        // Si el formulario no ha sido enviado, mostrar un mensaje
        echo "<p>Por favor, selecciona un valor para convertir y haz clic en 'Convertir'.</p>";
    }
    ?>

    <br>
    <a href="pagina.html">Volver</a>
</body>
</html>

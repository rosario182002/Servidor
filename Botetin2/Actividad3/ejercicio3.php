<?php
// Inicializar mensaje de salida
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la edad introducida
    $edad = (int)$_POST['edad'];

    // Verificar la edad y establecer el mensaje correspondiente
    if ($edad < 18) {
        $mensaje = "Acceso prohibido: Eres menor de edad.";
    } elseif ($edad > 65) {
        $mensaje = "Lo sentimos, el contenido no es para jubilados.";
    } else {
        $mensaje = "Bienvenido a la web www.srcodigofuente.es/adultos-nojubilados.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso a Contenido Especial</title>
</head>
<body>
    <h1>Acceso a Contenido Especial</h1>
    <form method="post" action="">
        <label for="edad">Introduce tu edad:</label>
        <input type="number" id="edad" name="edad" min="0" required>
        <button type="submit">Enviar</button>
    </form>

    <p><?php echo $mensaje; ?></p>
</body>
</html>

<?php
session_start();

// Verifica si el tamaño de la tabla y las casillas están definidas
if (!isset($_SESSION['tamaño'])) {
    header("Location: pagina.html");
    exit();
}

$tamaño = $_SESSION['tamaño'];
$casillasMarcadas = isset($_POST['casillas']) ? $_POST['casillas'] : [];
$numMarcadas = count($casillasMarcadas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>
<body>
    <h1>RESULTADO</h1>
    <p>Ha marcado <?php echo $numMarcadas; ?> casillas de un total de <?php echo $tamaño; ?>.</p>

    <?php if ($numMarcadas > 0): ?>
        <p>Casillas marcadas: <?php echo implode(", ", $casillasMarcadas); ?></p>
    <?php else: ?>
        <p>No ha marcado ninguna casilla.</p>
    <?php endif; ?>

    <br>
    <a href="codigo.php">Volver a la tabla</a> <br><br>
    <a href="pagina.html">Volver al formulario inicial</a>
</body>
</html>

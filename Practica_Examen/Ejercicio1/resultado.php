<?php
session_start();

// Verifica si se han enviado las casillas marcadas
if (!isset($_POST['casillas'])) {
    // Redirige si no se han marcado casillas
    header("Location: codigo.php");
    exit();
}

// Recibe las casillas marcadas
$casillasMarcadas = $_POST['casillas'];
$totalCasillas = $_SESSION['tamaño'];
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
    <p>Ha marcado <?php echo $numMarcadas; ?> casillas de un total de <?php echo $totalCasillas; ?>.</p>

    <?php if ($numMarcadas > 0): ?>
        <p>Casillas marcadas: <?php echo implode(", ", $casillasMarcadas); ?></p>
    <?php else: ?>
        <p>No ha marcado ninguna casilla.</p>
    <?php endif; ?>

    <br>
    <a href="tabla.php">Volver a la tabla</a> <br><br>
    <a href="pagina.html">Volver al formulario inicial</a>
</body>
</html>

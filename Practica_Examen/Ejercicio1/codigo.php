<?php
session_start();

// Verifica si se ha establecido el tamaño de la tabla
if (!isset($_SESSION['tamaño'])) {
    // Si no se ha enviado el tamaño, redirige a la página principal
    header("Location: pagina.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 1: Rosario Delgado Moreno</title>
    
</head>
<body>
    <h1>Tabla de una fila con casillas de verificación (Formulario 2)</h1>
    <p>Marque las casillas de verificación que quiera y contaré cuántas ha marcado:</p>

    <form method="POST" action="resultado.php">
        <table>
            <tr>
                <?php
                // Muestra las casillas de verificación según el tamaño de la tabla
                for ($i = 1; $i <= $_SESSION['tamaño']; $i++) {
                    echo "<td><input type='checkbox' name='casillas[]' value='$i'> $i</td>";
                }
                ?>
            </tr>
        </table>
        <br>
        <button type="submit">Contar</button>
        <button type="reset">Borrar</button>
    </form>

    <br>
    <a href="pagina.html">Volver al formulario inicial</a>
</body>
</html>

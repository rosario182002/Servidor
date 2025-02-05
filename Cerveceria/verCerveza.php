<?php
session_start();
require_once 'conexion.php';

// Habilitar los mensajes de error para ver los detalles (esto se debe desactivar en producción)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario es admin
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Verificar si se ha pasado un id
if (!isset($_GET['id'])) {
    die("ID de cerveza no proporcionado.");
}

// Obtener el id de la cerveza y asegurarse de que sea un número entero
$id = intval($_GET['id']);

// Realizar la consulta para obtener los detalles de la cerveza
$sql = "SELECT * FROM cervezas WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta.");
}

$result = $stmt->execute([$id]);

if (!$result) {
    die("Error al ejecutar la consulta.");
}

$cerveza = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cerveza) {
    die("Cerveza no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Cerveza</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <h1>Detalles de la Cerveza</h1>
    <p><strong>Denominación:</strong> <?= htmlspecialchars($cerveza['denominacion']); ?></p>
    <p><strong>Marca:</strong> <?= htmlspecialchars($cerveza['marca']); ?></p>
    <p><strong>Tipo:</strong> <?= htmlspecialchars($cerveza['tipo']); ?></p>
    <p><strong>Formato:</strong> <?= htmlspecialchars($cerveza['formato']); ?></p>
    <p><strong>Tamaño:</strong> <?= htmlspecialchars($cerveza['tamano']); ?></p>
    <p><strong>Foto:</strong><br>
        <?php
            // Verificar si la imagen existe antes de mostrarla
            $fotoPath = "imagenes/" . htmlspecialchars($cerveza['foto']);
            if (file_exists($fotoPath)) {
                echo '<img src="' . $fotoPath . '" alt="Imagen de ' . htmlspecialchars($cerveza['marca']) . '" width="200">';
            } else {
                echo '<img src="imagenes/no_imagen_disponible.jpg" alt="Imagen no disponible" width="200">';
            }
        ?>
    </p>
    <a href="listar_cervezas.php">Volver al listado</a>
</body>
</html>

<?php
// Cerrar la conexión
$conn = null;
?>

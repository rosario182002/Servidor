<?php
session_start();
require_once '../General/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../General/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    die("ID de cerveza no proporcionado.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM cervezas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cerveza no encontrada.");
}

$cerveza = $result->fetch_assoc();
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
        <img src="imagenes/<?= htmlspecialchars($cerveza['foto']); ?>" alt="Imagen de <?= htmlspecialchars($cerveza['marca']); ?>" width="200">
    </p>
    <a href="../General/listar_cervezas.php">Volver al listado</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM cervezas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: listar_cervezas.php");
        exit();
    } else {
        echo "Error al eliminar la cerveza: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Cerveza</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Eliminar Cerveza</h1>
    <p>¿Estás seguro de que deseas eliminar esta cerveza?</p>
    <p><strong>Denominación:</strong> <?= htmlspecialchars($cerveza['denominacion']); ?></p>
    <p><strong>Marca:</strong> <?= htmlspecialchars($cerveza['marca']); ?></p>
    <form method="post">
        <button type="submit">Eliminar</button>
        <a href="listar_cervezas.php">Cancelar</a>
    </form>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

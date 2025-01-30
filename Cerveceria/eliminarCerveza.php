<?php
session_start();
require_once 'conexion.php';

// Verificar conexión a la base de datos
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Verificar si el ID es válido
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$id) {
    die("ID de cerveza no válido.");
}

// Obtener datos de la cerveza antes de eliminarla
$sql = "SELECT * FROM cervezas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cerveza no encontrada.");
}

$cerveza = $result->fetch_assoc();
$stmt->close(); // Cerrar el statement antes de reusarlo

// Si el usuario confirma la eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM cervezas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Cerveza eliminada correctamente.</p>";
        echo "<a href='listar_cervezas.php'>Volver al listado</a>";
        exit();
    } else {
        echo "<p style='color:red;'>Error al eliminar la cerveza: " . $stmt->error . "</p>";
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

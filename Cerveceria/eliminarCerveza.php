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
    header('Location: listar_cervezas.php?error=ID de cerveza no válido.');
    exit();
}

// Obtener datos de la cerveza antes de eliminarla
$sql = "SELECT * FROM cervezas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Si no se encuentra la cerveza
if ($result->num_rows === 0) {
    header('Location: listar_cervezas.php?error=Cerveza no encontrada.');
    exit();
}

$cerveza = $result->fetch_assoc();
$stmt->close(); // Cerrar el statement después de usarlo

// Si el usuario confirma la eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM cervezas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header('Location: listar_cervezas.php?success=Cerveza eliminada correctamente.');
        exit();
    } else {
        // Error en la eliminación
        header('Location: listar_cervezas.php?error=Error al eliminar la cerveza.');
        exit();
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
    
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <p>¿Estás seguro de que deseas eliminar esta cerveza?</p>
    <p><strong>Denominación:</strong> <?= htmlspecialchars($cerveza['denominacion']); ?></p>
    <p><strong>Marca:</strong> <?= htmlspecialchars($cerveza['marca']); ?></p>

    <form method="post">
        <button type="submit">Eliminar</button>
        <a href="listar_cervezas.php" style="color: blue; text-decoration: none;">Cancelar</a>
    </form>
</body>
</html>

<?php
$conn->close(); // Cerrar la conexión al final
?>

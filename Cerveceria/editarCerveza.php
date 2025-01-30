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

// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $denominacion = htmlspecialchars($_POST['denominacion']);
    $marca = htmlspecialchars($_POST['marca']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $formato = htmlspecialchars($_POST['formato']);
    $tamano = htmlspecialchars($_POST['tamano']);

    $sql = "UPDATE cervezas SET denominacion = ?, marca = ?, tipo = ?, formato = ?, tamano = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $denominacion, $marca, $tipo, $formato, $tamano, $id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Cerveza actualizada correctamente.</p>";
        echo "<a href='listar_cervezas.php'>Volver al listado</a>";
    } else {
        echo "<p style='color:red;'>Error al actualizar la cerveza: " . $stmt->error . "</p>";
    }
}

// Obtener datos actuales de la cerveza
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
    <title>Editar Cerveza</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <h1>Editar Cerveza</h1>
    <form method="post">
        <label for="denominacion">Denominación:</label>
        <input type="text" id="denominacion" name="denominacion" value="<?= htmlspecialchars($cerveza['denominacion']); ?>" required><br>
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="<?= htmlspecialchars($cerveza['marca']); ?>" required><br>
        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($cerveza['tipo']); ?>" required><br>
        <label for="formato">Formato:</label>
        <input type="text" id="formato" name="formato" value="<?= htmlspecialchars($cerveza['formato']); ?>" required><br>
        <label for="tamano">Tamaño:</label>
        <input type="text" id="tamano" name="tamano" value="<?= htmlspecialchars($cerveza['tamano']); ?>" required><br>
        <button type="submit">Guardar Cambios</button>
    </form>
    <a href="listar_cervezas.php">Volver al listado</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

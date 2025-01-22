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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $denominacion = $_POST['denominacion'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $formato = $_POST['formato'];
    $tamano = $_POST['tamano'];

    $sql = "UPDATE cervezas SET denominacion = ?, marca = ?, tipo = ?, formato = ?, tamano = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $denominacion, $marca, $tipo, $formato, $tamano, $id);

    if ($stmt->execute()) {
        header("Location: listar_cervezas.php");
        exit();
    } else {
        echo "Error al actualizar la cerveza: " . $conn->error;
    }
}

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
s
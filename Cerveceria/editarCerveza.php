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
    // En lugar de simplemente dar error, se redirige con un mensaje
    header("Location: listar_cervezas.php?error=ID no válido");
    exit();
}

// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $denominacion = htmlspecialchars($_POST['denominacion']);
    $marca = htmlspecialchars($_POST['marca']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $formato = htmlspecialchars($_POST['formato']);
    $tamano = htmlspecialchars($_POST['tamano']);

    // Validación básica de los datos (puedes personalizarla más según tus necesidades)
    if (empty($denominacion) || empty($marca) || empty($tipo) || empty($formato) || empty($tamano)) {
        $mensaje_error = "Todos los campos son obligatorios.";
    } else {
        // Actualizar los datos de la cerveza
        $sql = "UPDATE cervezas SET denominacion = ?, marca = ?, tipo = ?, formato = ?, tamano = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $denominacion, $marca, $tipo, $formato, $tamano, $id);

        if ($stmt->execute()) {
            // Redirigir a la lista de cervezas con un mensaje de éxito
            header("Location: listar_cervezas.php?success=Cerveza actualizada correctamente");
            exit();
        } else {
            $mensaje_error = "Error al actualizar la cerveza: " . $stmt->error;
        }
    }
}

// Obtener datos actuales de la cerveza
$sql = "SELECT * FROM cervezas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Redirigir con mensaje de error si no se encuentra la cerveza
    header("Location: listar_cervezas.php?error=Cerveza no encontrada");
    exit();
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

    <?php if (isset($mensaje_error)): ?>
        <p style="color:red;"><?= $mensaje_error ?></p>
    <?php endif; ?>

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

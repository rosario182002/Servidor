<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Verificar si se proporciona un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: productos.php?error=ID de producto no válido.');
    exit();
}

$id = intval($_GET['id']);

// Obtener los datos del producto para el formulario
try {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        header('Location: productos.php?error=Producto no encontrado.');
        exit();
    }
} catch (PDOException $e) {
    header('Location: productos.php?error=Error al obtener el producto: ' . $e->getMessage());
    exit();
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $denominacion = htmlspecialchars($_POST['denominacion']);
    $marca = htmlspecialchars($_POST['marca']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $formato = htmlspecialchars($_POST['formato']);
    $tamano = htmlspecialchars($_POST['tamano']);
    $precio = floatval($_POST['precio']);
    $imagen = htmlspecialchars($_POST['imagen']);
    $observaciones = htmlspecialchars($_POST['observaciones']);

    // Validación (mejora esta validación)
    if (empty($denominacion) || empty($marca) || empty($tipo) || empty($formato) || empty($tamano) || empty($precio)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            $sql = "UPDATE productos SET denominacion = ?, marca = ?, tipo = ?, formato = ?, tamaño = ?, precio = ?, imagen = ?, observaciones = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$denominacion, $marca, $tipo, $formato, $tamano, $precio, $imagen, $observaciones, $id]);
            $success = "Producto actualizado correctamente.";

            // Redirigir para evitar reenvío del formulario
            header('Location: productos.php?success=' . urlencode($success));
            exit();

        } catch (PDOException $e) {
            $error = "Error al actualizar el producto: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <header>
        <h1>Editar Producto</h1>
        <nav>
            <ul>
                <li><a href="productos.php">Volver a Productos</a></li>
                <li><a href="administrador.php">Volver al Panel</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="denominacion">Denominación:</label>
            <input type="text" name="denominacion" value="<?= htmlspecialchars($producto['denominacion']) ?>" required><br>
            <label for="marca">Marca:</label>
            <input type="text" name="marca" value="<?= htmlspecialchars($producto['marca']) ?>" required><br>
            <label for="tipo">Tipo:</label>
            <input type="text" name="tipo" value="<?= htmlspecialchars($producto['tipo']) ?>" required><br>
            <label for="formato">Formato:</label>
            <input type="text" name="formato" value="<?= htmlspecialchars($producto['formato']) ?>" required><br>
            <label for="tamano">Tamaño:</label>
            <input type="text" name="tamano" value="<?= htmlspecialchars($producto['tamaño']) ?>" required><br>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required><br>
            <label for="imagen">URL Imagen:</label>
            <input type="text" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>"><br>
            <label for="observaciones">Observaciones:</label>
            <textarea name="observaciones"><?= htmlspecialchars($producto['observaciones']) ?></textarea><br>
            <button type="submit">Guardar Cambios</button>
        </form>
    </main>
</body>
</html>
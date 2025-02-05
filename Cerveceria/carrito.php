<?php
session_start();
include 'conexion.php';

// Verificar si la conexión es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario está logueado y no es administrador
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] === 'admin')) {
    header('Location: login.php');
    exit();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para obtener información de los productos en el carrito
function obtenerProducto($idProducto) {
    global $conn;
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idProducto);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultado);  // Retorna los detalles del producto
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
    </header>
    <main>
        <h2>Productos en tu Carrito</h2>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <ul>
                <?php foreach ($_SESSION['carrito'] as $productoId): ?>
                    <?php 
                    $producto = obtenerProducto($productoId); // Obtener datos del producto de la base de datos
                    if ($producto):
                    ?>
                        <li>
                            <?= htmlspecialchars($producto['denominacion'], ENT_QUOTES, 'UTF-8') ?> - 
                            <?= number_format($producto['precio'], 2) ?> USD
                            <a href="eliminarProducto.php?id=<?= htmlspecialchars($producto['id']) ?>">Eliminar</a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <button>Finalizar compra</button>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
        <a href="index.php">Seguir comprando</a>
    </main>
</body>
</html>

<?php
mysqli_close($conn);  // Cerrar la conexión a la base de datos
?>

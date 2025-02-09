<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para obtener información de un producto desde la base de datos
function obtenerProducto($idProducto, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$idProducto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $producto;
    } catch (PDOException $e) {
        echo "Error al obtener el producto: " . $e->getMessage();
        return null;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
    <style>
        .carrito-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .carrito-item img {
            max-width: 80px;
            height: auto;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
    </header>
    <main>
        <h2>Productos en tu Carrito</h2>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <ul>
                <?php
                $total = 0; // Inicializar el total
                foreach ($_SESSION['carrito'] as $productoId => $cantidad):
                    $producto = obtenerProducto($productoId, $pdo);
                    if ($producto):
                        $total += $producto['precio'] * $cantidad; // Sumar el precio al total
                        $imagen = !empty($producto['imagen']) ? htmlspecialchars($producto['imagen']) : "imagenes/default.jpg";
                        ?>
                        <li class="carrito-item">
                            <img src="<?= $imagen ?>" alt="Imagen de <?= htmlspecialchars($producto['denominacion']) ?>">
                            <div>
                                <?= htmlspecialchars($producto['denominacion'], ENT_QUOTES, 'UTF-8') ?> -
                                <?= number_format($producto['precio'], 2) ?> USD
                                (Cantidad: <?= $cantidad ?>)
                            </div>
                            <a href="eliminarProducto.php?id=<?= htmlspecialchars($producto['id']) ?>">Eliminar</a>
                        </li>
                    <?php else: ?>
                        <p>Producto con ID <?= htmlspecialchars($productoId) ?> no encontrado.</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <p>Total: <?= number_format($total, 2) ?> USD</p> <!-- Mostrar el total -->
            <button>Finalizar compra</button>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
        <a href="index.php">Seguir comprando</a>
    </main>
</body>
</html>
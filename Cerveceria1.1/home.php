<?php
session_start();
require_once 'productoController.php';

$productoController = new ProductoController();
$productos = $productoController->verProductosHome(); // Use the method to get products
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fiende CERVECERIA</title>
</head>
<body>
    <h1>Bienvenido a la cervecería</h1>
    <ul>
        <?php foreach ($productos as $producto): ?>
            <li><?php echo htmlspecialchars($producto['denominacion']) . " - " . htmlspecialchars($producto['marca']); ?> <a href="index.php?controller=carrito&action=agregarProducto&id=<?php echo $producto['id']; ?>">Agregar al carrito</a></li>
        <?php endforeach; ?>
    </ul>
    <?php if (isset($_SESSION['usuario'])): ?>
        <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>!  <a href="index.php?controller=usuario&action=logout">Cerrar sesión</a></p>
    <?php else: ?>
        <a href="index.php?controller=usuario&action=login">Iniciar sesión</a> | <a href="index.php?controller=usuario&action=register">Registrarse</a>
    <?php endif; ?>
</body>
</html>
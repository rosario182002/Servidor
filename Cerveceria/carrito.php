<?php
session_start();
include 'conexion.php';

// Verificar si la conexión es exitosa
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario está logueado y no es administrador
if (!isset($_SESSION['user_id']) || ($_SESSION['perfil'] === 'admin')) {
    header('Location: login.php');
    exit();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
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
                <?php foreach ($_SESSION['carrito'] as $producto): ?>
                    <li>
                        <?= htmlspecialchars($producto['nombre']) ?> - 
                        <?= number_format($producto['precio'], 2) ?> USD
                        <a href="eliminarCerveza.php?id=<?= $producto['id'] ?>">Eliminar</a>
                    </li>
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


<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] !== 'usuario') {
    header('Location: login.php');
    exit();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Lógica para agregar y eliminar productos (detalles no incluidos por brevedad)
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
        <!-- Mostrar productos en el carrito -->
    </main>
</body>
</html>

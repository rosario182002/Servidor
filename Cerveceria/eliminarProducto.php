<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si se ha enviado el ID del producto a eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productoId = intval($_GET['id']);

    // Asegurarse de que el carrito existe
    if (isset($_SESSION['carrito'])) {
        // Si la cantidad es mayor que 1, reducir la cantidad en 1
        if (isset($_SESSION['carrito'][$productoId]) && $_SESSION['carrito'][$productoId] > 1) {
            $_SESSION['carrito'][$productoId]--;
        } else {
            // Si la cantidad es 1 o no existe, eliminar el producto del carrito
            unset($_SESSION['carrito'][$productoId]);
        }
    }

    // Redirigir de vuelta al carrito
    header('Location: carrito.php');
    exit();
} else {
    // Si el ID no es válido, redirigir con un error
    header('Location: carrito.php?error=ID de producto no válido');
    exit();
}
?>
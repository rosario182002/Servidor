<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si se ha enviado el ID del producto
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productoId = intval($_GET['id']);

    echo "ID del producto recibido: " . $productoId . "<br>"; // Depuración

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
        echo "Carrito inicializado.<br>"; // Depuración
    }

    // Agregar el producto al carrito o aumentar la cantidad si ya existe
    if (isset($_SESSION['carrito'][$productoId])) {
        $_SESSION['carrito'][$productoId]++; // Aumentar la cantidad
        echo "Cantidad de producto " . $productoId . " aumentada a " . $_SESSION['carrito'][$productoId] . ".<br>"; // Depuración
    } else {
        $_SESSION['carrito'][$productoId] = 1; // Agregar el producto con cantidad 1
        echo "Producto " . $productoId . " agregado al carrito con cantidad 1.<br>"; // Depuración
    }

    var_dump($_SESSION['carrito']); // Depuración: Mostrar el contenido del carrito

    // Redirigir de vuelta a la página de productos o al carrito
    header('Location: carrito.php');
    exit();
} else {
    // Si el ID no es válido, redirigir con un error
    header('Location: index.php?error=ID de producto no válido');
    exit();
}
?>
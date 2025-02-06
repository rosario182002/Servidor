<?php
require_once 'carrito.php';

class CarritoController {
    public function verCarrito() {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $carrito = Carrito::getItems($_SESSION['usuario']['id']);
            include 'views/carrito.php';
        } else {
            echo "Por favor, inicie sesión.";
        }
    }

    public function agregarProducto($productoId) {
        session_start();
        if (isset($_SESSION['usuario'])) {
            Carrito::agregarProducto($_SESSION['usuario']['id'], $productoId);
            header('Location: index.php?controller=carrito&action=verCarrito');
            exit();
        } else {
            echo "Por favor, inicie sesión para agregar productos al carrito.";
        }
    }

    public function eliminarProducto($productoId) {
        session_start();
        if (isset($_SESSION['usuario'])) {
            Carrito::eliminarProducto($_SESSION['usuario']['id'], $productoId);
            header('Location: index.php?controller=carrito&action=verCarrito');
            exit();
        }
    }

    public function realizarCompra() {
        session_start();
        if (isset($_SESSION['usuario'])) {
            $total = Carrito::realizarCompra($_SESSION['usuario']['id']);
            include 'views/recibo.php'; // Mostrar el recibo de la compra
        }
    }
}
?>
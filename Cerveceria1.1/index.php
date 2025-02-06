<?php
session_start(); // Start the session at the very beginning

require_once 'config.php'; // Database configuration
require_once 'database.php';   // Database class definition (see below)
require_once 'producto.php';
require_once 'usuario.php';
require_once 'AdminController.php';
require_once 'UsuarioController.php';
require_once 'ProductoController.php';
require_once 'CarritoController.php';
require_once 'carrito.php';

// Determine the controller and action based on the request
$controller = $_GET['controller'] ?? 'home'; // Default to 'home'
$action     = $_GET['action']     ?? 'index';  // Default to 'index'

// Route the request to the appropriate controller and action
try {
    switch ($controller) {
        case 'admin':
            $adminController = new AdminController();
            switch ($action) {
                case 'verProductos':
                    $adminController->verProductos();
                    break;
                case 'verUsuarios':
                    $adminController->verUsuarios();
                    break;
                case 'eliminarProducto':
                    $adminController->eliminarProducto($_GET['id']);
                    break;
                case 'eliminarUsuario':
                    $adminController->eliminarUsuario($_GET['id']);
                    break;
                case 'editarProducto':
                    $adminController->editarProducto($_GET['id']);
                    break;
                 case 'editarUsuario':
                     $adminController->editarUsuario($_GET['id']);
                     break;
                default:
                    include 'admin.php';
                    break;
            }
            break;
        case 'usuario':
            $usuarioController = new UsuarioController();
            switch ($action) {
                case 'login':
                    $usuarioController->login();
                    break;
                case 'logout':
                    $usuarioController->logout();
                    break;
                case 'register':
                    $usuarioController->register();
                    break;
                default:
                    echo "Acción no válida";
            }
            break;
         case 'producto':
             $productoController = new ProductoController();
             switch ($action) {
                 case 'verProductos':
                     $productoController->verProductos();
                     break;
                 case 'verProducto':
                    $productoController->verProducto($_GET['id']);
                    break;
                 case 'eliminarProducto':
                     $productoController->eliminarProducto($_GET['id']);
                     break;
                 case 'agregarProducto':
                    $productoController->agregarProducto();
                    break;
                 case 'editarProducto':
                     $productoController->editarProducto($_GET['id']);
                     break;
                 default:
                     echo "Accion de producto no valida";
             }
             break;
        case 'carrito':
            $carritoController = new CarritoController();
            switch ($action) {
                case 'verCarrito':
                    $carritoController->verCarrito();
                    break;
                case 'agregarProducto':
                    $carritoController->agregarProducto($_GET['id']);
                    break;
                case 'eliminarProducto':
                    $carritoController->eliminarProducto($_GET['id']);
                    break;
                case 'realizarCompra':
                    $carritoController->realizarCompra();
                    break;
                default:
                    echo "Acción no válida";
            }
            break;
        case 'home':
        default:
            include 'home.php'; // Your main page with product listing and login link
            break;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();  // Basic error handling
}
?>
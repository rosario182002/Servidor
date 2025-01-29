<?php
session_start();
include '../General/conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../General/login.php');
    exit();
}

$perfil = $_SESSION['perfil']; // Perfil del usuario (admin o usuario)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Cervezas</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <header>
        <h1>Bienvenido a la Tienda de Cervezas</h1>
        <nav>
            <ul>
                <li><a href="../General/index.php">Inicio</a></li>
                <?php if ($perfil === 'admin'): ?>
                    <li><a href="../General/productos.php">Gestión de Productos</a></li>
                    <li><a href="../usuarios/usuarios.php">Gestión de Usuarios</a></li>
                <?php else: ?>
                    <li><a href="../usuarios/carrito.php">Carrito</a></li>
                <?php endif; ?>
                <li><a href="../General/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($perfil === 'admin'): ?>
            <h2>Panel de Administración</h2>
            <p>Utilice las opciones del menú para gestionar productos y usuarios.</p>
        <?php else: ?>
            <h2>Catálogo de Productos</h2>
            <div class="cervezas-container">
                <?php include '../General/listar_cervezas.php'; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Tienda de Cervezas</p>
    </footer>
</body>
</html>

<?php
session_start();
include 'conexion.php';

// Verificar conexión a la base de datos
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si el perfil está definido
$perfil = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : '';
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
                <li><a href="index.php">Inicio</a></li>
                <?php if ($perfil === 'admin'): ?>
                    <li><a href="productos.php">Gestión de Productos</a></li>
                    <li><a href="usuarios.php">Gestión de Usuarios</a></li>
                <?php else: ?>
                    <li><a href="carrito.php">Carrito</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Cerrar Sesión</a></li>
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
                <?php 
                ob_start();
                include 'listar_cervezas.php';
                ob_end_flush();
                ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Tienda de Cervezas</p>
    </footer>
</body>
</html>

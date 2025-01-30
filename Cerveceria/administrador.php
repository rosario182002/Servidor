<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="./estilos/estilos.css"> <!-- Verifica que la ruta sea correcta -->
</head>
<body>
    <header>
        <h1>Panel de Administrador</h1>
        <nav>
            <ul>
                <li><a href="productos.php">Gestión de Productos</a></li>
                <li><a href="usuarios.php">Gestión de Usuarios</a></li>
                <li><a href="index.php">Volver al Inicio</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li> <!-- Agregado botón de cierre de sesión -->
            </ul>
        </nav>
    </header>
    <main>
        <p>Bienvenido al panel de administrador. Seleccione una opción del menú para continuar.</p>
    </main>
</body>
</html>

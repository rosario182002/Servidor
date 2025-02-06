<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <ul>
                <li><a href="index.php?controller=admin&action=verProductos">Ver Productos</a></li>
                <li><a href="index.php?controller=admin&action=verUsuarios">Ver Usuarios</a></li>
                <li><a href="index.php">Volver al Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <?php
        if ($_GET['action'] == 'verProductos') {
            include 'ver_productos.php';
        } elseif ($_GET['action'] == 'verUsuarios') {
            include 'ver_usuarios.php';
        }else {
            echo "<h2>Bienvenido, Admin</h2>";
        }
        ?>
    </div>

    <footer>
        <p>© 2025 Proyecto</p>
    </footer>
</body>
</html>
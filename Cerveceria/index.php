<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener el perfil del usuario (admin o normal)
$perfil = $_SESSION['perfil'] ?? ''; // Usar operador null coalescing
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Cervezas</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
    <style>
        .cervezas-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .cerveza {
            width: 200px; /* Ancho fijo para cada contenedor de cerveza */
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .cerveza img {
            width: 150px;       /* Ancho fijo para todas las imágenes */
            height: 150px;      /* Alto fijo para todas las imágenes */
            object-fit: cover;   /* Asegura que la imagen cubra el espacio sin distorsionarse */
        }
    </style>
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
                // Obtener la lista de cervezas desde la base de datos
                try {
                    $stmt = $pdo->prepare("SELECT * FROM productos");
                    $stmt->execute();
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($productos) {
                        foreach ($productos as $producto) {
                            echo '<div class="cerveza">';
                            // Mostrar la imagen de la cerveza
                            $imagen = !empty($producto['imagen']) ? htmlspecialchars($producto['imagen']) : "imagenes/default.jpg";
                            echo '<img src="' . $imagen . '" alt="Imagen de ' . htmlspecialchars($producto['denominacion']) . '">';
                            echo '<h3>' . htmlspecialchars($producto['denominacion']) . '</h3>';
                            echo '<p>Marca: ' . htmlspecialchars($producto['marca']) . '</p>';
                            echo '<p>Tipo: ' . htmlspecialchars($producto['tipo']) . '</p>';
                            echo '<p>Precio: $' . number_format($producto['precio'], 2) . '</p>';

                            // Mostrar opciones para administradores
                            if ($perfil === 'admin') {
                                echo '<a href="editarProducto.php?id=' . htmlspecialchars($producto['id']) . '">Modificar Registro</a>';
                                echo ' | ';
                                echo '<a href="eliminarProducto.php?id=' . htmlspecialchars($producto['id']) . '">Borrar Registro</a>';
                            } else {
                                echo '<a href="agregarProducto.php?id=' . htmlspecialchars($producto['id']) . '">Agregar al carrito</a>';
                            }

                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay productos disponibles.</p>';
                    }
                } catch (PDOException $e) {
                    echo "Error al obtener productos: " . $e->getMessage();
                }
                ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2025 Tienda de Cervezas</p>
    </footer>
</body>
</html>
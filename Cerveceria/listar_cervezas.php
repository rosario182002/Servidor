<?php
session_start();
require_once 'conexion.php'; 

// Verificar conexión a la base de datos
if (!$conn) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario está logueado y tiene rol de admin
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Consultar productos en la base de datos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if (!$result) {
    die("Error al realizar la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Productos</title>
    <link rel="stylesheet" href="./estilos/estilos.css"> 
</head>
<body>
    <h1>Listado de Productos (Administrador)</h1>
    <a href="logout.php">Cerrar Sesión</a> <!-- Enlace para cerrar sesión -->
    
    <table border="1" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Denominación</th>
                <th>Marca</th>
                <th>Tipo</th>
                <th>Formato</th>
                <th>Tamaño</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $result->fetch_assoc()): ?>
                <?php $imagen = !empty($fila['imagen']) ? "imagenes/" . htmlspecialchars($fila['imagen']) : "imagenes/default.jpg"; ?>
                <tr>
                    <td><?= htmlspecialchars($fila['id']); ?></td>
                    <td><?= htmlspecialchars($fila['denominacion']); ?></td>
                    <td><?= htmlspecialchars($fila['marca']); ?></td>
                    <td><?= htmlspecialchars($fila['tipo']); ?></td>
                    <td><?= htmlspecialchars($fila['formato']); ?></td>
                    <td><?= htmlspecialchars($fila['tamano']); ?></td>
                    <td>
                        <img src="<?= $imagen ?>" alt="Imagen de <?= htmlspecialchars($fila['marca']); ?>" width="100">
                    </td>
                    <td>
                        <a href="verProducto.php?id=<?= htmlspecialchars($fila['id']); ?>">Ver más</a>
                        <a href="editarProducto.php?id=<?= htmlspecialchars($fila['id']); ?>">Modificar</a>
                        <a href="eliminarProducto.php?id=<?= htmlspecialchars($fila['id']); ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>

<?php
session_start();
require_once '../General/conexion.php'; // Archivo donde conectas tu base de datos

// Verificar si el usuario está logueado y si es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../General/login.php');
    exit();
}

// Consultar cervezas en la base de datos
$sql = "SELECT * FROM cervezas";
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
    <title>Listar Cervezas</title>
    <link rel="stylesheet" href="./estilos/estilos.css"> 
</head>
<body>
    <h1>Listado de Cervezas (Administrador)</h1>
    <a href="../General/logout.php">Cerrar Sesión</a> <!-- Enlace para cerrar sesión -->
    
    <table border="1">
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
                <tr>
                    <td><?= htmlspecialchars($fila['id']); ?></td>
                    <td><?= htmlspecialchars($fila['denominacion']); ?></td>
                    <td><?= htmlspecialchars($fila['marca']); ?></td>
                    <td><?= htmlspecialchars($fila['tipo']); ?></td>
                    <td><?= htmlspecialchars($fila['formato']); ?></td>
                    <td><?= htmlspecialchars($fila['tamano']); ?></td>
                    <td>
                        <img src="imagenes/<?= htmlspecialchars($fila['foto']); ?>" alt="Imagen de <?= htmlspecialchars($fila['marca']); ?>" width="100">
                    </td>
                    <td>
                        <a href="../usuarios/verCerveza.php?id=<?= $fila['id']; ?>">Ver más</a>
                        <a href="../administrador/editarCerveza.php?id=<?= $fila['id']; ?>">Modificar</a>
                        <a href="../administrador/eliminarCerveza.php?id=<?= $fila['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta cerveza?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close(); // Cerrar conexión a la base de datos
?>

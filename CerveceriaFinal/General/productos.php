
<?php
session_start();
//include '../General/conexion.php';

if ($_SESSION['perfil'] !== 'admin') {
    header('Location: ../General/login.php');
    exit();
}

// Insert a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $formato = $_POST['formato'];
    $tamaño = $_POST['tamano'];
    $alergias = implode(", ", $_POST['alergias']);
    $cantidad = $_POST['cantidad'];
    $foto = $_POST['foto'];
    $observaciones = $_POST['observaciones'];

    // Validar campos vacíos
    if (empty($nombre) || empty($marca) || empty($tipo) || empty($formato) || empty($tamaño) || empty($cantidad) || empty($foto)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO productos (Denominacion_Cerveza, Marca, Tipo_Envase, Cantidad, Alergias, Foto, Observaciones) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $marca, $tipo, $formato, $tamaño, $alergias, $foto, $observaciones]);
        $success = "Producto agregado con éxito.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <h1>Gestión de Productos</h1>
    <form method="POST" action="../General/productos.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="marca">Marca:</label>
        <input type="text" name="marca" required>
        <label for="tipo">Tipo de cerveza:</label>
        <select name="tipo">
            <option value="Lager">Lager</option>
            <option value="Pale Ale">Pale Ale</option>
            <option value="Cerveza Negra">Cerveza Negra</option>
            <option value="Abadía">Abadía</option>
            <option value="Rubia">Rubia</option>
        </select>
        <!-- Más campos aquí según sea necesario -->
        <button type="submit">Agregar Producto</button>
    </form>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php elseif (!empty($success)): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>
</body>
</html>

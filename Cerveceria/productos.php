<?php
session_start();
include 'conexion.php';

if ($_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Insert a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $formato = $_POST['formato'];
    $tamaño = $_POST['tamano'];
    $alergias = isset($_POST['alergias']) ? implode(", ", $_POST['alergias']) : ''; // Si no se seleccionan alergias, será una cadena vacía
    $cantidad = $_POST['cantidad'];
    $foto = $_POST['foto']; // Si decides usar imágenes como URL
    $observaciones = $_POST['observaciones'];

    // Validar campos vacíos
    if (empty($nombre) || empty($marca) || empty($tipo) || empty($formato) || empty($tamaño) || empty($cantidad) || empty($foto)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Consulta SQL
        $stmt = $pdo->prepare("INSERT INTO productos (Denominacion_Cerveza, Marca, Tipo_Envase, Formato, Tamano, Cantidad, Alergias, Foto, Observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $marca, $tipo, $formato, $tamaño, $cantidad, $alergias, $foto, $observaciones]);
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
    <form method="POST" action="productos.php">
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

        <label for="formato">Formato:</label>
        <input type="text" name="formato" required>

        <label for="tamano">Tamaño:</label>
        <input type="text" name="tamano" required>

        <label for="alergias">Alergias:</label>
        <input type="checkbox" name="alergias[]" value="Gluten"> Gluten
        <input type="checkbox" name="alergias[]" value="Lactosa"> Lactosa
        <input type="checkbox" name="alergias[]" value="Sulfitos"> Sulfitos
        <!-- Puedes agregar más alergias aquí si es necesario -->

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required>

        <label for="foto">Foto (URL):</label>
        <input type="text" name="foto" required>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones"></textarea>

        <button type="submit">Agregar Producto</button>
    </form>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php elseif (!empty($success)): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>
</body>
</html>

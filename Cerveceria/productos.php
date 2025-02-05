<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario tiene rol de admin
if ($_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Insertar un nuevo producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $denominacion = $_POST['nombre'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $formato = $_POST['formato'];
    $tamano = $_POST['tamano'];
    $alergias = isset($_POST['alergias']) ? implode(", ", $_POST['alergias']) : ''; // Alergias seleccionadas
    $cantidad = $_POST['cantidad'];
    $foto = $_POST['foto']; // URL de la foto
    $observaciones = $_POST['observaciones'];

    // Validar campos vacíos
    if (empty($denominacion) || empty($marca) || empty($tipo) || empty($formato) || empty($tamano) || empty($cantidad) || empty($foto)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Consulta SQL
        $stmt = $conn->prepare("INSERT INTO productos (denominacion, marca, tipo, formato, tamano, alergenos, precio, imagen, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssds", $denominacion, $marca, $tipo, $formato, $tamano, $alergias, $cantidad, $foto, $observaciones);
        
        if ($stmt->execute()) {
            $success = "Producto agregado con éxito.";
        } else {
            $error = "Hubo un problema al agregar el producto. Inténtalo de nuevo.";
        }
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
        <label for="nombre">Denominación:</label>
        <input type="text" name="nombre" required>

        <label for="marca">Marca:</label>
        <input type="text" name="marca" required>

        <label for="tipo">Tipo de Producto:</label>
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

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required>

        <label for="foto">Foto (URL):</label>
        <input type="text" name="foto" required>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones"></textarea>

        <button type="submit">Agregar Producto</button>
    </form>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($success)): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
</body>
</html>

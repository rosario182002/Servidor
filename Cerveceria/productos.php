<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Definir arrays para las opciones
$marcas = ["Heineken", "Mahou", "DAMM", "Estrella Galicia", "Alhambra", "Cruzcampo", "Artesana"];
$tipos = ["LAGER", "PALE ALE", "CERVEZA NEGRA", "ABADIA", "RUBIA"];
$formatos = ["Lata", "Botella", "Pack"];
$tamanos = ["botellín", "Tercio", "Media", "Litrona", "Pack"];
$alergenos_posibles = ["Gluten", "Huevo", "Cacahuete", "Soja", "Lactosa", "Sulfitos", "Sin Alérgenos"];

// Procesar formulario de agregar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $denominacion = htmlspecialchars($_POST['denominacion']);
    $marca = htmlspecialchars($_POST['marca']);
    $tipo = htmlspecialchars($_POST['tipo']);
    $formato = htmlspecialchars($_POST['formato']);
    $tamano = htmlspecialchars($_POST['tamano']);
    $precio = floatval($_POST['precio']); // Convertir a float
    $imagen = htmlspecialchars($_POST['imagen']); // URL de la imagen
    $fecha_consumo = htmlspecialchars($_POST['fecha_consumo']); //Fecha de consumo
    $alergenos = isset($_POST['alergenos']) ? implode(", ", $_POST['alergenos']) : '';
    $observaciones = htmlspecialchars($_POST['observaciones']);

    // Validación básica (puedes mejorarla)
    if (empty($denominacion) || empty($marca) || empty($tipo) || empty($formato) || empty($tamano) || empty($precio)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            $sql = "INSERT INTO productos (denominacion, marca, tipo, formato, tamaño, precio, imagen, fecha_consumo, alergenos, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$denominacion, $marca, $tipo, $formato, $tamano, $precio, $imagen, $fecha_consumo, $alergenos, $observaciones]);
            $success = "Producto agregado correctamente.";
        } catch (PDOException $e) {
            $error = "Error al agregar el producto: " . $e->getMessage();
        }
    }
}

// Obtener la lista de productos
try {
    $stmt = $pdo->prepare("SELECT * FROM productos");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al obtener los productos: " . $e->getMessage();
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
    <style>
       .error {color: red;}
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Productos</h1>
        <nav>
            <ul>
                <li><a href="administrador.php">Volver al Panel</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Lista de Productos</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Denominación</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['id']) ?></td>
                        <td><?= htmlspecialchars($producto['denominacion']) ?></td>
                        <td><?= htmlspecialchars($producto['marca']) ?></td>
                        <td><?= number_format($producto['precio'], 2) ?></td>
                        <td>
                            <a href="editarProducto.php?id=<?= htmlspecialchars($producto['id']) ?>">Editar</a>
                            <a href="eliminarProducto.php?id=<?= htmlspecialchars($producto['id']) ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <section id="insercion-cervezas">
        <h2>Inserción de Cervezas</h2>
        <p>Introduzca los datos de la Cerveza:</p>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <label for="denominacion">DENOMINACIÓN CERVEZA:<input type="text" name="denominacion" required></label>
            <p class="error">¡Se requiere el nombre de la Cerveza!</p>
            <label for="marca">MARCA:
            <select name="marca" required>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?= htmlspecialchars($marca) ?>"><?= htmlspecialchars($marca) ?></option>
                <?php endforeach; ?>
            </select></label>
            <br>
            <label>TIPO DE CERVEZA:</label><br>
            <?php foreach ($tipos as $tipo): ?>
                <label><input type="radio" name="tipo" value="<?= htmlspecialchars($tipo) ?>" required> <?= htmlspecialchars($tipo) ?></label>
            <?php endforeach; ?>
            <p class="error">¡Has de elegir un tipo de cerveza!</p>
            <label for="formato">FORMATO:
            <select name="formato" required>
                <?php foreach ($formatos as $formato): ?>
                    <option value="<?= htmlspecialchars($formato) ?>"><?= htmlspecialchars($formato) ?></option>
                <?php endforeach; ?>
            </select></label>
            <label for="tamano">TAMAÑO:
            <select name="tamano" required>
                <?php foreach ($tamanos as $tamano): ?>
                    <option value="<?= htmlspecialchars($tamano) ?>"><?= htmlspecialchars($tamano) ?></option>
                <?php endforeach; ?>
            </select></label>
            <br>
            <label>ALÉRGENOS:</label><br>
            <?php foreach ($alergenos_posibles as $alergeno): ?>
                <label><input type="checkbox" name="alergenos[]" value="<?= htmlspecialchars($alergeno) ?>"> <?= htmlspecialchars($alergeno) ?></label>
            <?php endforeach; ?>
            <p class="error">¡Has de elegir alérgenos!</p>
            <label for="fecha_consumo">FECHA CONSUMO: <input type="date" name="fecha_consumo"></label>
            <p class="error">¡Ha de tener una fecha de consumo máxima!</p>
            <label for="imagen">FOTO: <input type="text" name="imagen"></label>
            <label for="precio">PRECIO: <input type="number" name="precio" step="0.01" required></label>
            <p class="error">¡El precio debe ser un valor numérico!</p>
            <label for="observaciones">OBSERVACIONES:</label><textarea name="observaciones"></textarea>
            <button type="submit">Insertar Cerveza</button>
        </form>
        <?php if(isset($_POST['action']) && $_POST['action'] == 'add' && !empty($denominacion)): ?>
            <section id="datos-introducidos">
                <h2>Estos son los datos introducidos:</h2>
                <ul>
                    <li>DENOMINACIÓN CERVEZA: <?= htmlspecialchars($denominacion) ?></li>
                    <li>MARCA: <?= htmlspecialchars($marca) ?></li>
                    <li>TIPO CERVEZA: <?= htmlspecialchars($tipo) ?></li>
                    <li>FORMATO: <?= htmlspecialchars($formato) ?></li>
                    <li>TAMAÑO: <?= htmlspecialchars($tamano) ?></li>
                    <li>ALÉRGENOS: <?= htmlspecialchars($alergenos) ?></li>
                    <li>FECHA CONSUMO: <?= htmlspecialchars($fecha_consumo) ?></li>
                    <li>FOTO: <?= htmlspecialchars($imagen) ?></li>
                    <li>PRECIO: <?= htmlspecialchars($precio) ?></li>
                    <li>OBSERVACIONES: <?= htmlspecialchars($observaciones) ?></li>
                </ul>
                <a href="productos.php">Insertar otra cerveza</a>
            </section>
        <?php endif; ?>
        </section>
    </main>
</body>
</html>
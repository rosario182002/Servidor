<h2>Editar Producto</h2>
<form method="POST" action="index.php?controller=admin&action=editarProducto&id=<?php echo $producto['id']; ?>">
    <label>Denominación: </label>
    <input type="text" name="denominacion" value="<?php echo htmlspecialchars($producto['denominacion']); ?>" required><br>

    <label>Marca: </label>
    <input type="text" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required><br>

    <label>Tipo: </label>
    <input type="text" name="tipo" value="<?php echo htmlspecialchars($producto['tipo']); ?>" required><br>

    <label>Formato: </label>
    <input type="text" name="formato" value="<?php echo htmlspecialchars($producto['formato']); ?>" required><br>

    <label>Tamaño: </label>
    <input type="text" name="tamano" value="<?php echo htmlspecialchars($producto['tamano']); ?>" required><br>

    <button type="submit">Actualizar Producto</button>
</form>
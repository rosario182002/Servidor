<h2>Listado de Productos</h2>
<a href="index.php?controller=producto&action=agregarProducto">Agregar Nuevo Producto</a>
<table>
    <thead>
        <tr>
            <th>Denominación</th>
            <th>Marca</th>
            <th>Tipo</th>
            <th>Formato</th>
            <th>Tamaño</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['denominacion']); ?></td>
                <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                <td><?php echo htmlspecialchars($producto['tipo']); ?></td>
                <td><?php echo htmlspecialchars($producto['formato']); ?></td>
                <td><?php echo htmlspecialchars($producto['tamano']); ?></td>
                <td>
                    <a href="index.php?controller=admin&action=editarProducto&id=<?php echo $producto['id']; ?>">Editar</a> |
                    <a href="index.php?controller=admin&action=eliminarProducto&id=<?php echo $producto['id']; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
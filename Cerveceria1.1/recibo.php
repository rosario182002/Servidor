<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Compra</title>
</head>
<body>
    <h1>Recibo de Compra</h1>
    <?php if (isset($total['compra'])): ?>
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
            </tr>
            <?php foreach ($total['compra'] as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['denominacion']); ?></td>
                <td><?php echo htmlspecialchars($producto['precio']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Total: <?php echo htmlspecialchars($total['total']); ?></h3>
    <?php else: ?>
        <p>No hay items en la compra.</p>
    <?php endif; ?>
    <p>Gracias por tu compra</p>
</body>
</html>
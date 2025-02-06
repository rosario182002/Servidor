<h2>Listado de Usuarios</h2>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td>
                    <a href="index.php?controller=admin&action=editarUsuario&id=<?php echo $usuario['id']; ?>">Editar</a> |
                    <a href="index.php?controller=admin&action=eliminarUsuario&id=<?php echo $usuario['id']; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
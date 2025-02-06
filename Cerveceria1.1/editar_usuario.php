<h2>Editar Usuario</h2>
<form method="POST" action="index.php?controller=admin&action=editarUsuario&id=<?php echo $usuario['id']; ?>">
    <label>Nombre: </label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>

    <label>Email: </label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br>

    <label>Contraseña: </label>
    <input type="password" name="password" placeholder="Dejar en blanco si no se desea cambiar"><br>

    <button type="submit">Actualizar Usuario</button>
</form>
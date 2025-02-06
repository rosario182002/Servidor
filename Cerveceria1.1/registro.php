<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <form method="POST" action="index.php?controller=usuario&action=register">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
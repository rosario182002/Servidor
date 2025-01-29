<?php
session_start();
include '../General/conexion.php';

// Si el formulario se envió, procesa el login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Escapar las entradas para evitar inyección SQL
    $correo = mysqli_real_escape_string($conn, $correo);
    
    // Realizar la consulta
    $query = "SELECT * FROM usuario WHERE correo = '$correo'";
    $resultado = mysqli_query($conn, $query);

    // Verificar si el usuario existe
    if ($fila = mysqli_fetch_assoc($resultado)) {
        // Comparar directamente las contraseñas (sin encriptar)
        if ($password === $fila['password']) {
            // Guardar datos en sesión
            $_SESSION['user_id'] = $fila['id_usuario'];
            $_SESSION['perfil'] = $fila['perfil']; 

            // Redirigir según el perfil
            if ($fila['perfil'] === 'admin') {
                header('Location: ../General/productos.php');
                exit();
            } else {
                header('Location: ../usuarios/carrito.php');
                exit();
            }
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="../General/login.php">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Ingresar</button>
    </form>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
</body>
</html>

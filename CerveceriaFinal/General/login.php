<?php
session_start();
//include '../General/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($conn)) {
        die("Error: No se pudo conectar a la base de datos.");
    }

    $query = "SELECT * FROM usuario WHERE correo = '$correo'";
    $resultado = mysqli_query($conn, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        // Usar password_verify() si las contraseñas están encriptadas
        if (password_verify($password, $fila['password'])) {
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
            header("Location: ../General/login.php?error=1");
            exit();
        }
    } else {
        header("Location: ../General/login.php?error=1");
        exit();
    }
}
mysqli_close($conn);
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

<?php
session_start();
require_once 'conexion.php';  // Incluye la conexión a la base de datos

// Verificar si ya existe una sesión activa
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Verificar si se ha enviado el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitiza el email
    $password = $_POST['password']; // Obtén la contraseña

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de correo inválido.";
    } else {
        // Consulta para verificar el email y el perfil del usuario
        $sql = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Si el usuario existe
        if ($fila = $resultado->fetch_assoc()) {
            // Verificar que la contraseña sea correcta
            if (password_verify($password, $fila['password'])) {
                $_SESSION['user_id'] = $fila['id'];  // Guardar ID del usuario
                $_SESSION['perfil'] = $fila['role']; // Guardar perfil (admin o normal)

                // Redirigir según el perfil
                if ($fila['role'] === 'admin') {
                    header('Location: administrador.php'); // Panel de administración
                } else {
                    header('Location: index.php');  // Redirigir a tienda si es cliente
                }
                exit();
            } else {
                $error = "Credenciales incorrectas. Inténtalo de nuevo.";
            }
        } else {
            $error = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    }
}
?>

<!-- HTML de login -->
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
    <form method="POST" action="login.php">
        <label for="email">Correo:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Ingresar</button>
    </form>
    
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</body>
</html>

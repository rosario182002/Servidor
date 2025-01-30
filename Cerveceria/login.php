<?php
session_start();

// Conectar a la base de datos (ajusta los parámetros según tu configuración)
$conn = mysqli_connect("localhost", "root", "", "cerveceria", 3308);

// Verificar la conexión
if (!$conn) {
    die("Error de conexión a MySQL: " . mysqli_connect_error());
}

$error = ""; // Inicializar la variable de error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar correo antes de la consulta
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de correo inválido.";
    } else {
        // Preparar consulta para evitar inyección SQL
        $query = "SELECT * FROM usuario WHERE correo = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($fila = mysqli_fetch_assoc($resultado)) {
            // Verificar la contraseña encriptada
            if (password_verify($password, $fila['password'])) {
                session_regenerate_id(true); // Evita secuestro de sesión
                $_SESSION['user_id'] = $fila['id_usuario'];
                $_SESSION['perfil'] = $fila['perfil'];

                // Depuración: Verificar que la sesión se está guardando correctamente
                var_dump($_SESSION); // Esto te ayudará a ver si la sesión se está guardando correctamente

                // Redirigir según el perfil
                switch ($fila['perfil']) {
                    case 'admin':
                        header('Location: admin_dashboard.php');
                        exit();
                    case 'cliente':
                        header('Location: tienda.php');
                        exit();
                    default:
                        header('Location: index.php');
                        exit();
                }
            } else {
                $error = "Credenciales incorrectas. Inténtalo de nuevo.";
            }
        } else {
            $error = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    }
    mysqli_stmt_close($stmt);
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
    <form method="POST" action="login.php">
        <label for="email">Correo:</label>
        <input type="email" name="email" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit">Ingresar</button>
    </form>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</body>
</html>

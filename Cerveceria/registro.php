<?php
session_start();
include('conexion.php');

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Verificar si las contraseñas coinciden
    if ($contraseña != $confirmar_contraseña) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
    } else {
        // Validar contraseña segura
        if (strlen($contraseña) < 8) {
            $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres.";
        } elseif (!preg_match('/[A-Z]/', $contraseña)) {
            $_SESSION['error'] = "La contraseña debe contener al menos una letra mayúscula.";
        } elseif (!preg_match('/[a-z]/', $contraseña)) {
            $_SESSION['error'] = "La contraseña debe contener al menos una letra minúscula.";
        } elseif (!preg_match('/[0-9]/', $contraseña)) {
            $_SESSION['error'] = "La contraseña debe contener al menos un número.";
        } elseif (!preg_match('/[\W_]/', $contraseña)) { // Verifica caracteres especiales
            $_SESSION['error'] = "La contraseña debe contener al menos un carácter especial.";
        } else {
            // Verificar si el usuario o correo ya están registrados
            $stmt = $conn->prepare("SELECT COUNT(*) AS cuenta FROM usuario WHERE email = ?");
            $stmt->bind_param('s', $email); // 's' indica que el parámetro es una cadena (string)
            $stmt->execute();
            $stmt->bind_result($cuenta);
            $stmt->fetch();

            if ($cuenta > 0) {
                $_SESSION['error'] = "El correo electrónico ya está registrado.";
            } else {
                // Encriptar la contraseña con password_hash()
                $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

                try {
                    // Insertar los datos en la base de datos
                    $stmt = $conn->prepare("INSERT INTO usuario (email, name, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param('ssss', $email, $nombre_usuario, $contraseña_hash, $role); // 'ssss' indica 4 cadenas

                    $role = 'normal'; // Asumimos que el registro es para un usuario normal
                    $stmt->execute();
                    
                    $_SESSION['success'] = "Registro exitoso. ¡Puedes iniciar sesión ahora!";
                    header("Location: login.php"); // Redirigir al login después de un registro exitoso
                    exit();
                } catch (mysqli_sql_exception $e) {
                    $_SESSION['error'] = "Error al registrar el usuario: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tienda Cervecera</title>
    <link href="estilos/estilos.css" rel="stylesheet" />
</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
    </header>

    <main>
        <div class="container">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<p class="success">' . $_SESSION['success'] . '</p>';
                unset($_SESSION['success']);
            }
            ?>
            <form action="registro.php" method="POST">
                <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required />
                <input type="email" name="email" placeholder="Correo electrónico" required />
                <input type="password" name="contraseña" placeholder="Contraseña" required />
                <input type="password" name="confirmar_contraseña" placeholder="Confirmar contraseña" required />
                <button type="submit">Registrarse</button>
            </form>
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Tienda de Cervezas Online. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<?php
// Iniciar sesión para manejar posibles mensajes de error o éxito
session_start();

// Incluir la conexión a la base de datos
include('conexion.php');

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
        // Insertar los datos en la base de datos sin encriptar la contraseña
        try {
            $stmt = $conn->prepare("INSERT INTO usuario (nombre_usuario, correo, password) VALUES (?, ?, ?)");
            $stmt->execute([$nombre_usuario, $email, $contraseña]);
        
            $_SESSION['success'] = "Registro exitoso. ¡Puedes iniciar sesión ahora!";
            header("Location: login.php"); // Redirigir al login después de un registro exitoso
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error al registrar el usuario: " . $e->getMessage();
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

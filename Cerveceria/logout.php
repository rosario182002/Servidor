<?php
session_start();
require_once 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario está logueado
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del usuario
    $user_id = $_SESSION['user_id'];
    
    // Registrar la hora de cierre de sesión en la base de datos
    $sql = "UPDATE usuario SET last_logout = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        // Si la actualización fue exitosa, vaciar la sesión
        $_SESSION = []; // Vaciar el array de sesión

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy(); // Destruir la sesión
        header('Location: login.php'); // Redirigir al login
        exit();
    } else {
        // Si la actualización falla, puedes mostrar un error o continuar con el cierre de sesión
        $_SESSION = [];
        session_destroy();
        header('Location: login.php');
        exit();
    }
} else {
    // Si no hay sesión activa, redirigir al login
    header('Location: login.php');
    exit();
}

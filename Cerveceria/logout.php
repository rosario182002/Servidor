<?php
session_start();
require_once 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario está logueado
if (isset($_SESSION['user_id'])) {
    // Obtener el ID del usuario
    $user_id = $_SESSION['user_id'];

    // Registrar la hora de cierre de sesión en la base de datos
    try {
        $stmt = $pdo->prepare("UPDATE usuario SET last_logout = NOW() WHERE id = ?");
        $stmt->execute([$user_id]);

        // Verificar si la actualización fue exitosa (opcional)
        if ($stmt->rowCount() > 0) {
            // Éxito al actualizar la hora de cierre de sesión
        } else {
            // La actualización no afectó a ninguna fila (posiblemente el usuario no existe)
            // Puedes registrar este evento si lo deseas
        }

    } catch (PDOException $e) {
        // Error al actualizar la hora de cierre de sesión
        error_log("Error al actualizar la hora de cierre de sesión: " . $e->getMessage()); // Registrar el error
        // Podrías mostrar un mensaje de error al usuario (opcional)
    }

    // Vaciar la sesión
    $_SESSION = []; // Vaciar el array de sesión

    // Eliminar la cookie de sesión (si está habilitada)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destruir la sesión
    session_destroy();

    // Redirigir al login
    header('Location: login.php');
    exit();

} else {
    // Si no hay sesión activa, redirigir al login
    header('Location: login.php');
    exit();
}
?>
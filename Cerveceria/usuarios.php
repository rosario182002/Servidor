<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Procesar operaciones CRUD para usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Agregar usuario
            $email = htmlspecialchars($_POST['email']);
            $name = htmlspecialchars($_POST['name']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = htmlspecialchars($_POST['role']); // Obtener el rol del formulario

            if (!empty($email) && !empty($password) && !empty($name) && !empty($role)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO usuario (email, name, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$email, $name, $password, $role]);
                    $success = "Usuario agregado con éxito.";
                } catch (PDOException $e) {
                    $error = "Error al agregar usuario: " . $e->getMessage();
                }
            } else {
                $error = "Todos los campos son obligatorios.";
            }
        } elseif ($_POST['action'] === 'delete') {
            // Eliminar usuario
            $id = intval($_POST['id']); // Asegurarse de que el ID sea un entero

            // Evitar que un administrador se elimine a sí mismo
            if ($id === $_SESSION['user_id']) {
                $error = "No puedes eliminar tu propia cuenta.";
            } else {
                try {
                    $stmt = $pdo->prepare("DELETE FROM usuario WHERE id = ?");
                    $stmt->execute([$id]);
                    $success = "Usuario eliminado con éxito.";
                } catch (PDOException $e) {
                    $error = "Error al eliminar usuario: " . $e->getMessage();
                }
            }
        }
    }
}

// Obtener lista de usuarios
try {
    $stmt = $pdo->prepare("SELECT id, email, name, role FROM usuario"); // No seleccionar la contraseña
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al obtener la lista de usuarios: " . $e->getMessage();
    $usuarios = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
</head>
<body>
    <header>
        <h1>Gestión de Usuarios</h1>
        <nav>
            <ul>
                <li><a href="administrador.php">Volver al Panel</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Lista de Usuarios</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Correo</th>
                    <th>Nombre</th>
                    <th>Perfil</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= htmlspecialchars($usuario['name']) ?></td>
                        <td><?= htmlspecialchars($usuario['role']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Agregar Usuario</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <label for="email">Correo:</label>
            <input type="email" name="email" required><br>
            <label for="name">Nombre:</label>
            <input type="text" name="name" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>
            <label for="role">Perfil:</label>
            <select name="role" required>
                <option value="normal">Usuario</option>
                <option value="admin">Administrador</option>
            </select><br>
            <button type="submit">Agregar Usuario</button>
        </form>
    </main>
</body>
</html>
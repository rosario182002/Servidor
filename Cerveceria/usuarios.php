<?php
session_start();
include 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Procesar operaciones CRUD para usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Agregar usuario
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $age = $_POST['age'];
            $role = $_POST['role'];

            if (!empty($email) && !empty($password) && !empty($name) && !empty($age) && !empty($role)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO usuario (email, name, password, age, role) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$email, $name, $password, $age, $role]);
                    $success = "Usuario agregado con éxito.";
                } catch (PDOException $e) {
                    $error = "Error al agregar usuario: " . $e->getMessage();
                }
            } else {
                $error = "Todos los campos son obligatorios.";
            }
        } elseif ($_POST['action'] === 'delete') {
            // Eliminar usuario
            $id = $_POST['id'];
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

// Obtener lista de usuarios
$stmt = $pdo->query("SELECT * FROM usuario");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    </header>
    <main>
        <h2>Lista de Usuarios</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Correo</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['name']) ?></td>
                    <td><?= htmlspecialchars($usuario['age']) ?></td>
                    <td><?= htmlspecialchars($usuario['role']) ?></td>
                    <td>
                        <form method="POST" action="usuarios.php">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
                            <button type="submit" name="action" value="delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Agregar Usuario</h2>
        <form method="POST" action="usuarios.php">
            <label for="email">Correo:</label>
            <input type="email" name="email" required>
            <label for="name">Nombre:</label>
            <input type="text" name="name" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <label for="age">Edad:</label>
            <input type="number" name="age" required>
            <label for="role">Perfil:</label>
            <select name="role" required>
                <option value="admin">Administrador</option>
                <option value="user">Usuario</option>
            </select>
            <button type="submit" name="action" value="add">Agregar Usuario</button>
        </form>

        <?php if (!empty($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif (!empty($success)): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
    </main>
</body>
</html>

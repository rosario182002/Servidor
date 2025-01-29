<?php
session_start();
include '../General/conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: ../General/login.php');
    exit();
}

// Procesar operaciones CRUD para usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Agregar usuario
            $correo = $_POST['correo'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $edad = $_POST['edad'];
            $perfil = $_POST['perfil'];

            if (!empty($correo) && !empty($password) && !empty($edad) && !empty($perfil)) {
                $stmt = $pdo->prepare("INSERT INTO usuario (CORREO, PASSWORD, EDAD, PERFIL) VALUES (?, ?, ?, ?)");
                $stmt->execute([$correo, $password, $edad, $perfil]);
                $success = "Usuario agregado con éxito.";
            } else {
                $error = "Todos los campos son obligatorios.";
            }
        } elseif ($_POST['action'] === 'delete') {
            // Eliminar usuario
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE ID_USUARIO = ?");
            $stmt->execute([$id]);
            $success = "Usuario eliminado con éxito.";
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
                <th>Edad</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['ID_USUARIO'] ?></td>
                    <td><?= $usuario['CORREO'] ?></td>
                    <td><?= $usuario['EDAD'] ?></td>
                    <td><?= $usuario['PERFIL'] ?></td>
                    <td>
                        <form method="POST" action="../usuarios/usuarios.php">
                            <input type="hidden" name="id" value="<?= $usuario['ID_USUARIO'] ?>">
                            <button type="submit" name="action" value="delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Agregar Usuario</h2>
        <form method="POST" action="../usuarios/usuarios.php">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <label for="edad">Edad:</label>
            <input type="number" name="edad" required>
            <label for="perfil">Perfil:</label>
            <select name="perfil" required>
                <option value="admin">Administrador</option>
                <option value="usuario">Usuario</option>
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

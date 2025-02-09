<?php
session_start();
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = htmlspecialchars($_POST['nombre_usuario']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Validaciones (¡Importantísimo mantenerlas!)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "El correo electrónico no es válido.";
        header("Location: registro.php");
        exit();
    }

    if ($contraseña !== $confirmar_contraseña) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: registro.php");
        exit();
    }

    // Validar contraseña segura (longitud, mayúsculas, minúsculas, números, símbolos)
    if (strlen($contraseña) < 8 || !preg_match('/[A-Z]/', $contraseña) || !preg_match('/[a-z]/', $contraseña) || !preg_match('/[0-9]/', $contraseña) || !preg_match('/[\W_]/', $contraseña)) {
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres y contener al menos una mayúscula, una minúscula, un número y un símbolo.";
        header("Location: registro.php");
        exit();
    }

    try {
        // Verificar si el correo ya está registrado
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = "El correo electrónico ya está registrado.";
            header("Location: registro.php");
            exit();
        }

        // Encriptar la contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        // Insertar el usuario
        $stmt = $pdo->prepare("INSERT INTO usuario (email, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $nombre_usuario, $contraseña_hash, 'normal']);

        $_SESSION['success'] = "Registro exitoso. ¡Puedes iniciar sesión ahora!";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al registrar: " . $e->getMessage();
        header("Location: registro.php");
        exit();
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
    <style>
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 150%;       
            max-width: 250px;   
            padding: 8px;       
            margin-bottom: 10px;  
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }

        button[type="submit"] {
            background-color: #4CAF50; 
            color: white;          
            padding: 10px 15px;     
            border: none;          
            border-radius: 4px;     
            cursor: pointer;        
        }

        button[type="submit"]:hover {
            background-color: #3e8e41; 
        }
    </style>
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
        <p>© 2025 Tienda de Cervezas Online. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
<?php
session_start();
include('conexion.php');

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']); 
    $password = preg_replace('/[^\x00-\x7F]+/', '', $password); 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de correo inválido.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                $fila['password'] = trim($fila['password']); 

                $verificado = password_verify($password, $fila['password']);

                
                var_dump($password); 
                var_dump($fila['password']); 
                var_dump($verificado); 

                if ($verificado) {
                    $_SESSION['user_id'] = $fila['id'];
                    $_SESSION['perfil'] = $fila['role'];
                    header('Location: ' . ($fila['role'] === 'admin' ? 'administrador.php' : 'index.php'));
                    exit();
                } else {
                    $error = "Credenciales incorrectas.";
                }
            } else {
                $error = "Credenciales incorrectas.";
            }

        } catch (PDOException $e) {
            $error = "Error al iniciar sesión: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./estilos/estilos.css">
    <meta charset="UTF-8">
    <style>
        form {
            width: 300px;                
            margin: 0 auto;            
            padding: 20px;             
            border: 1px solid #ccc;    
            border-radius: 5px;         
            display: flex;             
            flex-direction: column;    
        }

        label {
            display: block;            
            margin-bottom: 5px;        
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;                
            padding: 8px;              
            margin-bottom: 15px;        
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

        .error {
            color: red;                
            margin-top: 10px;           
        }
    </style>
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
        <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</body>
</html>
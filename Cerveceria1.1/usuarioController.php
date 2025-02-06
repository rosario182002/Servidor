<?php
require_once 'usuario.php';

class UsuarioController {
    public function login() {
        // Verificación del usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $usuario = Usuario::verificarPassword($email, $password);
                if ($usuario) {
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    header('Location: index.php');
                    exit();
                } else {
                    $error = "Email o contraseña incorrectos.";
                    include 'login.php';
                    return;
                }
            }
        }
        include 'login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit();
    }

    public function register() {
        // Registro de un nuevo usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                Usuario::registrar($nombre, $email, $password);
                header('Location: index.php?controller=usuario&action=login');
                exit();
            }
        }
        include 'registro.php';
    }
}
?>
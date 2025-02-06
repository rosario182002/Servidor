<?php
require_once 'database.php';

class Usuario {
    private $id;
    private $nombre;
    private $email;
    private $password;

    // Constructor
    public function __construct($id, $nombre, $email, $password) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    // Función para obtener todos los usuarios
    public static function getAll() {
        $db = new Database();
        return $db->query("SELECT * FROM usuarios");
    }

    // Función para obtener un usuario por su ID
    public static function getById($id) {
        $db = new Database();
        return $db->query("SELECT * FROM usuarios WHERE id = ?", [$id]);
    }


    // Verificación de la contraseña
    public static function verificarPassword($email, $password) {
        $db = new Database();
        $users = $db->query("SELECT * FROM usuarios WHERE email = ?", [$email]);

        if ($users) {
            $usuario = $users[0];
            if (password_verify($password, $usuario['password'])) {
                return $usuario;
            }
        }

        return null;
    }

    // Registrar nuevo usuario con contraseña encriptada
    public static function registrar($nombre, $email, $password) {
        $db = new Database();
        $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
        $db->query("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)", [$nombre, $email, $password_encrypted]);
    }
    public static function eliminar($id) {
        $db = new Database();
        $db->query("DELETE FROM usuarios WHERE id = ?", [$id]);
    }

    public static function actualizar($id, $nombre, $email, $password) {
        $db = new Database();
        $db->query("UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?",
                    [$nombre, $email, $password, $id]);
    }



}
?>
<?php
require_once 'producto.php';
require_once 'usuario.php';

class AdminController {

    public function verProductos() {
        $productos = Producto::getAll();
        include 'admin.php';
    }

    public function verUsuarios() {
        $usuarios = Usuario::getAll();
        include 'admin.php';
    }

    public function eliminarProducto($id) {
        Producto::eliminar($id);
        header('Location: index.php?controller=admin&action=verProductos');
        exit();
    }

    public function eliminarUsuario($id) {
        Usuario::eliminar($id);
        header('Location: index.php?controller=admin&action=verUsuarios');
        exit();
    }

    public function editarProducto($id) {
        $producto = Producto::getById($id)[0]; // Access the first element of the array
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input
            $denominacion = htmlspecialchars($_POST['denominacion']);
            $marca = htmlspecialchars($_POST['marca']);
            $tipo = htmlspecialchars($_POST['tipo']);
            $formato = htmlspecialchars($_POST['formato']);
            $tamano = htmlspecialchars($_POST['tamano']);

            $datos = [
                'denominacion' => $denominacion,
                'marca' => $marca,
                'tipo' => $tipo,
                'formato' => $formato,
                'tamano' => $tamano
            ];

            Producto::actualizar($id, $datos);
            header('Location: index.php?controller=admin&action=verProductos');
            exit();
        }
        include 'editar_producto.php';
    }

    public function editarUsuario($id) {
        $usuario = Usuario::getById($id)[0]; // Access the first element of the array
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input
            $nombre = htmlspecialchars($_POST['nombre']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if ($email === false) {
                echo "Invalid email format";
                return;
            }

            if (!empty($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                // If password is not changed, keep the old password
                $password = $usuario['password'];
            }

            $data = [
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password
            ];
            Usuario::actualizar($id, $nombre, $email, $password);
            header('Location: index.php?controller=admin&action=verUsuarios');
            exit();
        }
        include 'editar_usuario.php';
    }

}
?>
<?php
require_once 'producto.php';

class ProductoController {

    public function verProductos() {
        // Obtener todos los productos desde el modelo
        $productos = Producto::getAll();
        include 'ver_productos.php';  // Vista donde se mostrarán los productos
    }

        public function verProductosHome() {
        // Obtener todos los productos desde el modelo
        return Producto::getAll(); // Return the products, don't include a view
    }

    // Función para ver un producto específico (detalles del producto)
    public function verProducto($id) {
        // Obtener producto específico
        $producto = Producto::getById($id)[0];
        include 'ver_producto_detalle.php';  // Vista para ver los detalles del producto
    }

    // Función para agregar un producto
    public function agregarProducto() {
        // Si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar los datos y agregar el producto a la base de datos
            $denominacion = htmlspecialchars($_POST['denominacion']);
            $marca = htmlspecialchars($_POST['marca']);
            $tipo = htmlspecialchars($_POST['tipo']);
            $formato = htmlspecialchars($_POST['formato']);
            $tamano = htmlspecialchars($_POST['tamano']);
            $foto = htmlspecialchars($_POST['foto']);

            // Insertar el nuevo producto en la base de datos
            Producto::agregar($denominacion, $marca, $tipo, $formato, $tamano, $foto);

            // Redirigir a la vista de productos
            header('Location: index.php?controller=admin&action=verProductos');
            exit();
        }

        // Mostrar la vista para agregar un producto
        include 'agregar_producto.php';
    }

    // Función para editar un producto
    public function editarProducto($id) {
        // Obtener el producto para editarlo
        $producto = Producto::getById($id)[0];

        // Si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y actualizar el producto en la base de datos
             $denominacion = htmlspecialchars($_POST['denominacion']);
             $marca = htmlspecialchars($_POST['marca']);
             $tipo = htmlspecialchars($_POST['tipo']);
             $formato = htmlspecialchars($_POST['formato']);
             $tamano = htmlspecialchars($_POST['tamano']);
            $foto = htmlspecialchars($_POST['foto']);

            $data = [
                'denominacion' => $denominacion,
                'marca' => $marca,
                'tipo' => $tipo,
                'formato' => $formato,
                'tamano' => $tamano,
                'foto' => $foto
            ];

            // Actualizar el producto
            Producto::actualizar($id, $data);

            // Redirigir a la vista de productos
            header('Location: index.php?controller=admin&action=verProductos');
            exit();
        }

        // Mostrar la vista de edición del producto
        include 'editar_producto.php';
    }

    // Función para eliminar un producto
    public function eliminarProducto($id) {
        // Eliminar el producto de la base de datos
        Producto::eliminar($id);

        // Redirigir de nuevo a la lista de productos
        header('Location: index.php?controller=admin&action=verProductos');
        exit();
    }

    // Función para buscar productos
    public function buscarProductos($filtro) {
        // Filtrar los productos según el filtro proporcionado
        $productos = Producto::filtrar($filtro);
        include 'ver_productos.php';  // Mostrar productos filtrados
    }
}
?>
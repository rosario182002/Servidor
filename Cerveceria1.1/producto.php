<?php
require_once 'database.php';

class Producto {
    private $id;
    private $denominacion;
    private $marca;
    private $tipo;
    private $formato;
    private $tamano;
    private $foto;

    // Constructor
    public function __construct($id, $denominacion, $marca, $tipo, $formato, $tamano, $foto) {
        $this->id = $id;
        $this->denominacion = $denominacion;
        $this->marca = $marca;
        $this->tipo = $tipo;
        $this->formato = $formato;
        $this->tamano = $tamano;
        $this->foto = $foto;
    }

    // Función para obtener todos los productos
    public static function getAll() {
        $db = new Database();
        return $db->query("SELECT * FROM productos");
    }
    // Obtener un producto por su ID
    public static function getById($id) {
        $db = new Database();
        return $db->query("SELECT * FROM productos WHERE id = ?", [$id]);
    }

    // Función para obtener productos por filtro
    public static function filtrar($filtro) {
        $db = new Database();
        return $db->query("SELECT * FROM productos WHERE denominacion LIKE ? OR marca LIKE ? OR formato LIKE ? OR tamano LIKE ?", ["%$filtro%", "%$filtro%", "%$filtro%", "%$filtro%"]);
    }

    public static function eliminar($id) {
         $db = new Database();
        $db->query("DELETE FROM productos WHERE id = ?", [$id]);
    }

    public static function actualizar($id, $data) {
    $db = new Database();
    $db->query("UPDATE productos SET denominacion = ?, marca = ?, tipo = ?, formato = ?, tamano = ? WHERE id = ?",
        [$data['denominacion'], $data['marca'], $data['tipo'], $data['formato'], $data['tamano'], $id]);
}


    public static function agregar($denominacion, $marca, $tipo, $formato, $tamano, $foto) {
        $db = new Database();
        $db->query("INSERT INTO productos (denominacion, marca, tipo, formato, tamano, foto)
                    VALUES (?, ?, ?, ?, ?, ?)",
                    [$denominacion, $marca, $tipo, $formato, $tamano, $foto]);
    }


}
?>
<?php
require_once 'database.php';

class Carrito {
    public static function getItems($userId) {
        $db = new Database();
        return $db->query("SELECT c.id, p.denominacion, p.precio, c.cantidad
                             FROM carrito c
                             JOIN productos p ON c.producto_id = p.id
                             WHERE c.usuario_id = ?", [$userId]);
    }

    public static function agregarProducto($userId, $productoId) {
        $db = new Database();
        // Check if the product is already in the cart
        $existingItem = $db->query("SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?", [$userId, $productoId]);

        if ($existingItem) {
            // If the product exists, update the quantity
            $newQuantity = $existingItem[0]['cantidad'] + 1;
            $db->query("UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?", [$newQuantity, $userId, $productoId]);
        } else {
            // If the product doesn't exist, add it to the cart
            $db->query("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, 1)", [$userId, $productoId]);
        }
    }


    public static function eliminarProducto($userId, $productoId) {
        $db = new Database();
        $db->query("DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?", [$userId, $productoId]);
    }

    public static function realizarCompra($userId) {
        $db = new Database();
        $carritoItems = self::getItems($userId);
        $total = 0;
        $compra = [];

        foreach ($carritoItems as $item) {
            $total += $item['precio'] * $item['cantidad'];
            $compra[] = $item;
        }

        // Clear the cart after purchase
        $db->query("DELETE FROM carrito WHERE usuario_id = ?", [$userId]);

        return ['total' => $total, 'compra' => $compra];
    }

}
?>
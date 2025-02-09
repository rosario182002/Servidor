<?php
$host = 'localhost';    
$dbname = 'cerveceria';   
$user = 'root';           
$pass = '';            
$port = 3307;          

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
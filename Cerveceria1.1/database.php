<?php
require_once 'config.php';

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8"); // Important for character encoding
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $this->conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Assume all params are strings for now (adjust as needed)
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $stmt->close();

        if ($result) {
            if (is_object($result)) {
                $rows = [];
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                return $rows; // Return multiple rows as an array
            } else {
                return true;  // For INSERT, UPDATE, DELETE queries
            }
        }
        return false; // Query failed
    }

    public function getConnection() {
        return $this->conn;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
<?php
require_once 'constant.php';

class ManageProduct {
    private $conn;
    private $table = "products";

    public function __construct() {
        $db = new Database(); 
        $this->conn = $db->getConnection(); 
    }

    // Fetch all products
    public function getAllProducts() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Return the MySQLi result set, not as an array
        return $stmt->get_result(); // This returns a MySQLi result object
    }
    
    // Get product by ID
    public function getProductById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Add a new product
    public function addProduct($name, $description, $price, $image) {
        $query = "INSERT INTO {$this->table} (name, description, price, image, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssds", $name, $description, $price, $image);
        return $stmt->execute();
    }

    // Update an existing product
    public function updateProduct($id, $name, $description, $price, $image) {
        $query = "UPDATE {$this->table} SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
        return $stmt->execute();
    }

    // Delete a product
    public function deleteProduct($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Count total products
    public function countProducts() {
        $query = "SELECT COUNT(*) as total_products FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total_products'];
    }
}
?>

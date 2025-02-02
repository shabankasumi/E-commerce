<?php
require_once 'constant.php';

class ManageOrder {
    private $conn;
    private $table = "orders";

    public function __construct() {
        $db = new Database(); 
        $this->conn = $db->getConnection(); 
    }

    public function getAllOrders() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addOrder($userId, $productDetails, $totalAmount, $status) {
        $query = "INSERT INTO {$this->table} (user_id, product_details, total_amount, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isis", $userId, $productDetails, $totalAmount, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrder($orderId, $status) {
        $query = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status, $orderId);
        return $stmt->execute();
    }

    public function deleteOrder($orderId) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId);

        return $stmt->execute();
    }

    public function countOrders() {
        $query = "SELECT COUNT(*) as total_orders FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total_orders'];
    }
}
?>

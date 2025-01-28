<?php
require_once '../config/constant.php';

class ManageUser {
    private $conn;
    private $table = "users";

    public function __construct() {
        $db = new Database(); 
        $this->conn = $db->getConnection(); 
    }

    public function getAllUsers() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    public function addUser($username, $email, $password, $role = 'user') {
        $query = "INSERT INTO {$this->table} (username, email, password, role) VALUES (?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bind_param("ssss", $username, $email, $password, $role);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($id, $username, $email, $password) {
        $query = "UPDATE {$this->table} SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $username, $email, $password, $id); 
        return $stmt->execute(); 
    }
    public function deleteUser($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id); 
        return $stmt->execute(); 
    }

    public function countUsers() {
        $query = "SELECT COUNT(*) as total_users FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total_users'];
    }
}